import os
import time
import shutil
import subprocess  # Для запуску deploy.sh
import requests    # Для перевірки localhost:8000
import google.generativeai as genai

# --- 1. ГОЛОВНІ НАЛАШТУВАННЯ ---

# Вставте ваш API-ключ тут
GEMINI_API_KEY = "AIzaSyBo_ef7xvWhXabVbgUu3j84XPDkwU0Xv8Y"
MODEL_NAME = 'gemini-2.5-flash'
# Папки, які потрібно рекурсивно сканувати
PROJECT_DIRS = [
    '/home/roman/coolify/resources/views'
]

# Файли з якими розширеннями обробляти
FILE_EXTENSIONS = ('.php', '.html', '.htm')

# Файл для запису помилок
ERROR_LOG_FILE = os.path.join(PROJECT_DIRS[0], 'translation_errors.log')

# --- 2. НАЛАШТУВАННЯ ВАЛІДАЦІЇ ---

# Команда, яка запускає ваш Docker-контейнер
# ВАЖЛИВО: Скрипт Python повинен запускатися з тим самим CWD (поточною директорією),
# де лежить ваш deploy.sh, або вкажіть тут повний шлях.
DEPLOY_COMMAND = "sudo ./deploy.sh"

# URL для перевірки, що додаток "живий"
HEALTH_CHECK_URL = "http://localhost:8000"

# Скільки секунд чекати після deploy, перш ніж перевіряти URL
HEALTH_CHECK_DELAY_SECONDS = 10

# Скільки максимум спроб перекладу робити для одного файлу
MAX_TRANSLATION_ATTEMPTS = 2

# --- 3. ПРОМТИ ДЛЯ GEMINI ---

# Промт для першої спроби
MASTER_PROMPT = """
Роль: Ти — досвідчений програміст-лінгвіст, експерт з локалізації (l10n) програмного забезпечення. Твоє завдання — допомогти мені з перекладом проєкту, який містить файли PHP, HTML, а також, можливо, JS та CSS.

Головна Мета: Перекласти лише той текст, який бачить кінцевий користувач (UI-текст) з [МОВА_ОРИГІНАЛУ] на [ЦІЛЬОВА_МОВА].

Я буду надавати тобі вміст файлів один за одним. Твоє завдання — проаналізувати код і повернути мені повний вміст файлу з акуратно перекладеними рядками.
### ‼️ ВАЖЛИВО! ФОРМАТ ВІДПОВІДІ:
Твоя відповідь повинна містити **ТІЛЬКИ** виправлений код.
НЕ пиши 'Ось виправлена версія...' або 'Я знайшов помилку...'. ТІЛЬКИ ЧИСТИЙ КОД.
❗️ Дуже Суворі Правила (Що НЕ можна перекладати):
Ти повинен ігнорувати та залишати без жодних змін:

Синтаксис Коду:

Будь-які ключові слова мови програмування (наприклад, if, else, while, for, function, class, public, private, echo, return, new).

Будь-які HTML/XML-теги (наприклад, <div>, <p>, <span>, <a>).

Будь-які назви атрибутів (наприклад, class=, id=, href=, src=, style=).

Імена та Ідентифікатори:

Назви змінних: (наприклад, $user_name, $config, $page_title, $i).

Назви функцій та методів: (наприклад, getUserData(), calculatePrice(), __construct()).

Назви класів, інтерфейсів та трейтів: (наприклад, UserController, DatabaseConnection).

Константи: (наприклад, APP_VERSION, DEFAULT_CURRENCY).

Ключі Масивів:

У конструкціях типу $lang['main_title'] = '...'; або $config['db_host'] = '...'; ти ніколи не повинен перекладати ключ ('main_title', 'db_host').

Технічні Рядки:

Шляхи до файлів (include 'views/header.php';).

URL-адреси (https://example.com).

Назви класів CSS ('btn-primary').

SQL-запити (SELECT * FROM users).

Коментарі до коду, призначені для розробників (// Це важлива логіка, /* TODO: ... */).

✅ Що Потрібно Перекладати:
НІ В ЯКОМУ РАЗІ НЕ ЧІПАЙ СТРУКТУРУ І НЕ ВИДАЛЯЙ БЛОКИ І КОД ЯКІ НЕ СТОСУЮТЬС ЯПЕРЕКЛАДИ ТИ ЛИШЕ ПЕРЕКЛАДАЄШ ТЕКСТ САМЕ КОД НЕ ЧІПАЦ І НЕ ВИДАЛЯЙ
Ти повинен знаходити та перекладати лише такі елементи:

Чистий Текст в HTML:

Текст, що знаходиться безпосередньо між тегами.

Приклад: <p>Hello, world!</p> → <p>Привіт, світе!</p>

Значення Атрибутів для Користувача:

Текст в атрибутах placeholder, title, alt.

Приклад: <input placeholder="Enter your name"> → <input placeholder="Введіть ваше ім'я">

Рядки в Коді, що Виводяться Користувачу:

Рядки, що використовуються в echo, print або присвоюються змінним, які потім виводяться.

Приклад: echo 'Welcome back!'; → echo 'З поверненням!';

Приклад: $page_title = 'My Profile'; → $page_title = 'Мій профіль';

Значення в Масивах Локалізації:

У конструкції $lang['main_title'] = 'Homepage'; ти повинен перекласти лише значення 'Homepage'.

Приклад: $lang['main_title'] = 'Homepage'; → $lang['main_title'] = 'Головна сторінка';

Процес Роботи:

Я даю тобі код файлу.

Ти аналізуєш його рядок за рядком, керуючись правилами вище.

Ти повертаєш мені повний код файлу з перекладеними рядками, зберігаючи всю структуру коду, відступи та імена ідентифікаторів.

Ти зрозумів завдання? Підтвердь, і я надішлю перший файл.
"""

# Промт для "розумної" другої спроби (виправлення помилок)
RETRY_PROMPT_TEMPLATE = """
Роль: Ти — програміст-лінгвіст, який виправляє помилки локалізації.
Твоя попередня спроба перекладу цього файлу призвела до **критичної помилки 500 на сервері**.
Це означає, що ти, ймовірно, випадково переклав частину коду (змінну, ключ масиву, назву функції або HTML-атрибут).

Ось твоя **ПОПЕРЕДНЯ НЕВДАЛА ВЕРСІЯ** (яка зламала додаток):
---
{failed_translation}
---

Будь ласка, проаналізуй ОРИГІНАЛЬНИЙ КОД ще раз. Порівняй його зі своєю невдалою версією,
знайди помилку і надай **НОВИЙ, БІЛЬШ УВАЖНИЙ** переклад.

Дотримуйся ДУЖЕ СУВОРИХ ПРАВИЛ: не чіпай нічого, що схоже на код.
Поверни ТІЛЬКИ повний виправлений код. Без жодних пояснень.

Ось **ОРИГІНАЛЬНИЙ КОД** для твоєї другої спроби:
---
{original_content}
"""

# --- 4. ЛОГІКА СКРИПТУ ---

def log_error(message):
    with open(ERROR_LOG_FILE, 'a', encoding='utf-8') as f:
        f.write(f"{time.ctime()}: {message}\n")

def translate_content(model, content, failed_attempt=None):

    try:
        if failed_attempt:
            prompt = RETRY_PROMPT_TEMPLATE.format(
                failed_translation=failed_attempt,
                original_content=content
            )
        else:
            prompt = MASTER_PROMPT + "\n\n" + content

        response = model.generate_content(prompt)
        raw_text = response.text.strip()
        
        # --- НОВА, БЕЗПЕЧНА ЛОГІКА ОЧИСТКИ ---

        # 1. Шукаємо початковий маркер блоку коду ```
        code_block_start = raw_text.find('```')
        
        if code_block_start != -1:
            # Знайшли ```, тепер шукаємо кінець першого рядка (де може бути ```php)
            end_of_marker_line = raw_text.find('\n', code_block_start)
            if end_of_marker_line == -1:
                # Якщо раптом відповідь - це один рядок ```code```
                end_of_marker_line = code_block_start + 3 

            # Реальний код починається *після* цього рядка
            code_start_index = end_of_marker_line + 1
            
            # Шукаємо останній (закриваючий) ```
            code_end_index = raw_text.rfind('```')
            
            if code_end_index > code_start_index:
                # Знайшли початок і кінець, беремо те, що між ними
                clean_code = raw_text[code_start_index:code_end_index].strip()
            else:
                # Знайшли тільки початковий ```, беремо все після нього
                # (Це менш надійно, але краще, ніж нічого)
                clean_code = raw_text[code_start_index:].strip()
            
            return clean_code

        # 2. ЯКЩО БЛОК КОДУ ``` НЕ ЗНАЙДЕНО:
        # Модель не дотрималась інструкції. 
        # Ми НЕ МОЖЕМО ризикувати і записувати raw_text, 
        # бо це може бути "Зрозумів завдання..." або "Ось код: @props...".
        # Вважаємо це помилкою.
        
        # Перевіримо, чи відповідь *випадково* не є чистим кодом (малоймовірно, але можливо)
        if content.strip().startswith(raw_text.strip()[:15]):
             log_error("API Warning: Response had no markdown, but looks like original code. Returning as is.")
             return raw_text # Повертаємо як є, бо схоже на оригінал (переклад не відбувся)

        # Це точно помилкова, розмовна відповідь.
        log_error(f"API Error: Response was conversational and NOT in a markdown block. Text: {raw_text[:200]}...")
        return None # Це змусить скрипт спробувати ще раз або відновити бекап

    except Exception as e:
        log_error(f"API Error in translate_content: {e}")
        return None

def run_deployment_and_validation():
    """Запускає deploy і перевіряє health check. Повертає True/False."""
    try:
        # 1. Запуск Deploy
        print(f"   [DEPLOY] Запускаю: {DEPLOY_COMMAND}...")
        # shell=True потрібен для sudo та ./
        result = subprocess.run(
            DEPLOY_COMMAND,
            shell=True,
            check=True,  # Викине помилку, якщо deploy.sh завершиться з ненульовим кодом
            capture_output=True, # Не спамити консоль виводом deploy
            text=True,
            timeout=300 # 5 хвилин на збірку
        )
        print("   [DEPLOY] Скрипт виконано успішно.")

        # 2. Очікування та Перевірка Здоров'я
        print(f"   [HEALTH] Очікую {HEALTH_CHECK_DELAY_SECONDS} сек...")
        time.sleep(HEALTH_CHECK_DELAY_SECONDS)
        
        print(f"   [HEALTH] Перевіряю: {HEALTH_CHECK_URL}...")
        response = requests.get(HEALTH_CHECK_URL, timeout=10)
        
        response.raise_for_status() # Викине помилку для 4xx або 5xx статусів
        
        print(f"   [HEALTH] Успіх (Статус {response.status_code}). Переклад коректний.")
        return True

    except subprocess.CalledProcessError as e:
        log_error(f"DEPLOY FAILED: {e.stderr}")
        print(f"   [ПОМИЛКА DEPLOY] Скрипт deploy.sh завершився з помилкою: {e.stderr}")
        return False
    except requests.exceptions.ConnectionError:
        log_error("HEALTH FAILED: Connection refused. Сервер не піднявся.")
        print("   [ПОМИЛКА HEALTH] Неможливо підключитися. Сервер впав.")
        return False
    except requests.exceptions.HTTPError as e:
        log_error(f"HEALTH FAILED: Сервер повернув помилку {e.response.status_code}")
        print(f"   [ПОМИЛКА HEALTH] Сервер відповів помилкою: {e.response.status_code} (Ймовірно 500!)")
        return False
    except Exception as e:
        log_error(f"VALIDATION FAILED (Unknown): {e}")
        print(f"   [ПОМИЛКА ВАЛІДАЦІЇ] Невідома помилка: {e}")
        return False

def revert_file(source_path, backup_path):
    """Відновлює оригінальний файл з бекапу."""
    print(f"   [REVERT] Відновлюю оригінал... {source_path}")
    try:
        if os.path.exists(source_path):
            os.remove(source_path)
        os.rename(backup_path, source_path)
        print("   [REVERT] Оригінал відновлено.")
        return True
    except Exception as e:
        log_error(f"CRITICAL REVERT FAILED for {source_path}: {e}")
        print(f"   [КРИТИЧНА ПОМИЛКА] Не вдалося відновити бекап {backup_path}!")
        return False

def main():
    print("--- Запуск 'Розумного' Перекладу з Валідацією ---")
    
    try:
        genai.configure(api_key=GEMINI_API_KEY)
        model = genai.GenerativeModel('gemini-2.5-flash') # 'gemini-pro'
    except Exception as e:
        print(f"Помилка конфігурації API: {e}")
        return

    print(f"Файл логів буде збережено в: {ERROR_LOG_FILE}")
    
    total_files = 0
    translated_files = 0
    skipped_files = 0

    for project_dir in PROJECT_DIRS:
        for root, dirs, files in os.walk(project_dir, topdown=True):
            dirs[:] = [d for d in dirs if d not in ['vendor', 'node_modules', '.git']]
            
            for file in files:
                if not file.endswith(FILE_EXTENSIONS):
                    continue

                total_files += 1
                source_path = os.path.join(root, file)
                backup_path = source_path + ".original" 

                if os.path.exists(backup_path):
                    print(f"\n[СКІП] Знайдено бекап. Файл вже оброблено: {source_path}")
                    skipped_files += 1
                    continue

                print(f"\n[РОБОТА] Обробляю файл: {source_path}")

                try:
                    with open(source_path, 'r', encoding='utf-8') as f:
                        original_content = f.read()
                        
                    if not original_content.strip():
                        print("[ІНФО] Файл порожній, пропускаю.")
                        skipped_files += 1
                        continue

                    # 1. СТВОРЮЄМО РЕЗЕРВНУ КОПІЮ
                    shutil.copy2(source_path, backup_path)
                    print(f"[ЗАХИСТ] Створено бекап: {backup_path}")

                    # --- Новий Цикл Спроб та Валідації ---
                    failed_translation_content = None
                    translation_success = False
                    
                    for attempt in range(1, MAX_TRANSLATION_ATTEMPTS + 1):
                        print(f"   [ATTEMPT {attempt}/{MAX_TRANSLATION_ATTEMPTS}] Надсилаю на переклад...")
                        
                        # 2. Переклад
                        translated_content = translate_content(
                            model,
                            original_content,
                            failed_attempt=failed_translation_content
                        )
                        
                        if not translated_content:
                            log_error(f"API call failed for {source_path}")
                            continue # Переходимо до наступної спроби

                        # 3. Запис перекладу
                        with open(source_path, 'w', encoding='utf-8') as f:
                            f.write(translated_content)
                        
                        # 4. Валідація (Deploy + Health Check)
                        if run_deployment_and_validation():
                            # УСПІХ!
                            print(f"[УСПІХ] Файл оновлено та верифіковано: {source_path}")
                            translated_files += 1
                            translation_success = True
                            break # Виходимо з циклу спроб (переходимо до наступного файлу)
                        else:
                            # ПРОВАЛ!
                            print(f"   [ПОМИЛКА] Збій верифікації (Спроба {attempt}).")
                            failed_translation_content = translated_content # Зберігаємо невдалий переклад
                            revert_file(source_path, backup_path)
                            # Цикл продовжиться до наступної спроби
                    
                    if not translation_success:
                        print(f"[ПОМИЛКА] Не вдалося перекласти {source_path} після {MAX_TRANSLATION_ATTEMPTS} спроб.")
                        log_error(f"Gave up on file {source_path}. File reverted to original.")
                        # Файл вже відновлено, просто йдемо далі

                except Exception as e:
                    log_error(f"Критична помилка при обробці файлу {source_path}: {e}")
                    print(f"[КРИТИЧНА ПОМИЛКА] {e}. Див. лог.")
                    if os.path.exists(backup_path):
                        revert_file(source_path, backup_path) # Гарантуємо відновлення

    print("\n--- Процес завершено ---")
    print(f"Всього файлів знайдено: {total_files}")
    print(f"Успішно перекладено та верифіковано: {translated_files}")
    print(f"Пропущено (вже оброблені або порожні): {skipped_files}")
    print(f"Файли, які не вдалося перекласти: {total_files - translated_files - skipped_files}")
    print(f"Всі помилки записано в: {ERROR_LOG_FILE}")

if __name__ == "__main__":
    main()