import os
import time
import shutil
import subprocess  # Для запуску deploy.sh
import requests    # Для перевірки localhost:8000
import re          # Для регістроненезалежної заміни

# --- 1. ГОЛОВНІ НАЛАШТУВАННЯ ---

GEMINI_API_KEY = "AIzaSyBo_ef7xvWhXabVbgUu3j84XPDkwU0Xv8Y"
MODEL_NAME = 'gemini-2.5-flash'
PROJECT_DIRS = [
    '/home/roman/coolify/resources/views'
]

# Файли з якими розширеннями обробляти
FILE_EXTENSIONS = ('.php', '.html', '.htm', '.blade.php') # Додано .blade.php для надійності

# Розширення для НОВОГО бекапу
BACKUP_EXTENSION = ".original2" # ЗМІНЕНО: Нове розширення бекапу

# Файл для запису помилок
ERROR_LOG_FILE = os.path.join(PROJECT_DIRS[0], 'replacement_errors.log')

# --- 2. НАЛАШТУВАННЯ ВАЛІДАЦІЇ ---

# Команда, яка запускає ваш Docker-контейнер
DEPLOY_COMMAND = "sudo ./deploy.sh"

# URL для перевірки, що додаток "живий"
HEALTH_CHECK_URL = "http://localhost:8000"

# Скільки секунд чекати після deploy, перш ніж перевіряти URL
HEALTH_CHECK_DELAY_SECONDS = 10

# --- 3. НАЛАШТУВАННЯ ЗАМІНИ ---
OLD_WORD_PATTERN = r"Coolify" # Регулярний вираз для пошуку слова "Coolify"
NEW_WORD = "AutoDeploy"     # Рядок для заміни

# --- 4. ЛОГІКА СКРИПТУ ---

def log_error(message):
    with open(ERROR_LOG_FILE, 'a', encoding='utf-8') as f:
        f.write(f"{time.ctime()}: {message}\n")

def find_and_replace_content(content):
    """
    Виконує регістронезалежну заміну слова Coolify на AutoDeploy.
    """
    try:
        # re.IGNORECASE забезпечує регістронезалежний пошук
        replaced_content = re.sub(OLD_WORD_PATTERN, NEW_WORD, content, flags=re.IGNORECASE)
        return replaced_content
    except Exception as e:
        log_error(f"Replacement Error in find_and_replace_content: {e}")
        return None

def run_deployment_and_validation():
    """Запускає deploy і перевіряє health check. Повертає True/False."""
    try:
        # 1. Запуск Deploy
        print(f"    [DEPLOY] Запускаю: {DEPLOY_COMMAND}...")
        result = subprocess.run(
            DEPLOY_COMMAND,
            shell=True,
            check=True,  
            capture_output=True,
            text=True,
            timeout=300
        )
        print("    [DEPLOY] Скрипт виконано успішно.")

        # 2. Очікування та Перевірка Здоров'я
        print(f"    [HEALTH] Очікую {HEALTH_CHECK_DELAY_SECONDS} сек...")
        time.sleep(HEALTH_CHECK_DELAY_SECONDS)
        
        print(f"    [HEALTH] Перевіряю: {HEALTH_CHECK_URL}...")
        response = requests.get(HEALTH_CHECK_URL, timeout=10)
        
        response.raise_for_status() 
        
        print(f"    [HEALTH] Успіх (Статус {response.status_code}). Заміна коректна.")
        return True

    except subprocess.CalledProcessError as e:
        log_error(f"DEPLOY FAILED: {e.stderr}")
        print(f"    [ПОМИЛКА DEPLOY] Скрипт deploy.sh завершився з помилкою: {e.stderr}")
        return False
    except requests.exceptions.ConnectionError:
        log_error("HEALTH FAILED: Connection refused. Сервер не піднявся.")
        print("    [ПОМИЛКА HEALTH] Неможливо підключитися. Сервер впав.")
        return False
    except requests.exceptions.HTTPError as e:
        log_error(f"HEALTH FAILED: Сервер повернув помилку {e.response.status_code}")
        print(f"    [ПОМИЛКА HEALTH] Сервер відповів помилкою: {e.response.status_code} (Ймовірно 500!)")
        return False
    except Exception as e:
        log_error(f"VALIDATION FAILED (Unknown): {e}")
        print(f"    [ПОМИЛКА ВАЛІДАЦІЇ] Невідома помилка: {e}")
        return False

def revert_file(source_path, backup_path):
    """Відновлює оригінальний файл з бекапу."""
    print(f"    [REVERT] Відновлюю оригінал... {source_path}")
    try:
        if os.path.exists(source_path):
            os.remove(source_path)
        os.rename(backup_path, source_path)
        print("    [REVERT] Оригінал відновлено.")
        return True
    except Exception as e:
        log_error(f"CRITICAL REVERT FAILED for {source_path}: {e}")
        print(f"    [КРИТИЧНА ПОМИЛКА] Не вдалося відновити бекап {backup_path}!")
        return False

def main():
    print("--- Запуск 'Розумної' Заміни з Валідацією ---")
    
    print(f"Файл логів буде збережено в: {ERROR_LOG_FILE}")
    print(f"Розширення для бекапів: {BACKUP_EXTENSION}")
    
    total_files = 0
    replaced_files = 0
    skipped_files = 0

    for project_dir in PROJECT_DIRS:
        for root, dirs, files in os.walk(project_dir, topdown=True):
            # Виключення технічних директорій
            dirs[:] = [d for d in dirs if d not in ['vendor', 'node_modules', '.git', 'cache']]
            
            for file in files:
                # Включаємо файли з розширенням .blade.php
                if not file.endswith(FILE_EXTENSIONS):
                    continue

                total_files += 1
                source_path = os.path.join(root, file)
                # ЗМІНЕНО: Використовуємо нове розширення бекапу
                backup_path = source_path + BACKUP_EXTENSION 

                # Перевіряємо, чи існує НОВИЙ бекап
                if os.path.exists(backup_path):
                    print(f"\n[СКІП] Знайдено бекап ({BACKUP_EXTENSION}). Файл вже оброблено: {source_path}")
                    skipped_files += 1
                    continue
                
                # Ігноруємо також старі бекапи, щоб не намагатися їх змінити
                if file.endswith('.original') or file.endswith('.original1'):
                    print(f"\n[ІГНОР] Пропускаю старий бекап: {source_path}")
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

                    # 1. СТВОРЮЄМО НОВИЙ РЕЗЕРВНУ КОПІЮ
                    shutil.copy2(source_path, backup_path)
                    print(f"[ЗАХИСТ] Створено бекап: {backup_path}")

                    # 2. Заміна тексту
                    replaced_content = find_and_replace_content(original_content)
                    
                    if not replaced_content:
                        log_error(f"Replacement failed for {source_path}")
                        os.remove(backup_path) 
                        continue 
                        
                    # Перевіряємо, чи відбулася зміна
                    if replaced_content == original_content:
                         print("[ІНФО] Слово 'Coolify' не знайдено. Пропускаю валідацію.")
                         os.remove(backup_path) # Видаляємо бекап, бо змін не було
                         skipped_files += 1
                         continue

                    # 3. Запис заміни
                    with open(source_path, 'w', encoding='utf-8') as f:
                        f.write(replaced_content)
                    print(f"    [REPLACE] Заміну виконано. Записую в {source_path}.")
                        
                    # 4. Валідація (Deploy + Health Check)
                    if run_deployment_and_validation():
                        # УСПІХ! Бекап .original2 залишається.
                        print(f"[УСПІХ] Файл оновлено та верифіковано: {source_path}")
                        replaced_files += 1
                    else:
                        # ПРОВАЛ! Відновлюємо оригінал і видаляємо бекап для повторної спроби.
                        print(f"    [ПОМИЛКА] Збій верифікації. Відновлюю оригінал.")
                        log_error(f"Gave up on file {source_path}. File reverted to original.")
                        revert_file(source_path, backup_path)
                        # Видаляємо бекап .original2, щоб файл був оброблений наступного разу
                        if os.path.exists(backup_path):
                            os.remove(backup_path)

                except Exception as e:
                    log_error(f"Критична помилка при обробці файлу {source_path}: {e}")
                    print(f"[КРИТИЧНА ПОМИЛКА] {e}. Див. лог.")
                    if os.path.exists(backup_path):
                        revert_file(source_path, backup_path) 
                        if os.path.exists(backup_path):
                            os.remove(backup_path) 

    print("\n--- Процес завершено ---")
    print(f"Всього файлів знайдено: {total_files}")
    print(f"Успішно замінено та верифіковано: {replaced_files}")
    print(f"Пропущено (вже оброблені, без змін, порожні або старі бекапи): {skipped_files}")
    failed_files = total_files - replaced_files - skipped_files
    print(f"Файли, які не вдалося замінити та верифікувати: {failed_files}")
    print(f"Всі помилки записано в: {ERROR_LOG_FILE}")

if __name__ == "__main__":
    main()