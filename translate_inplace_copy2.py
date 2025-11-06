import os
import time
import shutil
import re # Додано для роботи з регулярними виразами

# --- 1. ГОЛОВНІ НАЛАШТУВАННЯ ---
GEMINI_API_KEY = "AIzaSyBo_ef7xvWhXabVbgUu3j84XPDkwU0Xv8Y"
MODEL_NAME = 'gemini-2.5-flash'
# Папки, які потрібно рекурсивно сканувати
PROJECT_DIRS = [
    '/home/roman/coolify/resources/views'
]

# Файли з якими розширеннями обробляти
FILE_EXTENSIONS = ('.php', '.html', '.htm')

# Файл для запису помилок
ERROR_LOG_FILE = os.path.join(PROJECT_DIRS[0], 'link_removal_errors.log')

# --- 2. НАЛАШТУВАННЯ ВИДАЛЕННЯ ---
# Цільовий URL для видалення. Екрануємо крапку.
TARGET_URL_REGEX = r'autodeploy\.io/docs'

# --- 3. ЛОГІКА СКРИПТУ ---

def log_error(message):
    """Записує помилку у файл логів."""
    try:
        # Використовуємо time.ctime() для позначки часу, як у вашому оригінальному коді
        with open(ERROR_LOG_FILE, 'a', encoding='utf-8') as f:
            f.write(f"{time.ctime()}: {message}\n")
    except Exception as e:
        print(f"Критична помилка при записі в лог: {e}")

def remove_link_references(content):
    """
    Аналітично видаляє всі згадки про цільовий URL:
    1. Видаляє повний тег <a>, що містить посилання, а отже, і текст посилання.
    2. Видаляє сам URL-адресу, якщо вона зустрічається як чистий текст (з пробілами/пунктуацією навколо).
    """

    # 1. Видалення повних HTML-посилань (тегів <a>)
    # Патерн: <a ... href="...autodeploy.io/docs...">...</a>
    # Використовуємо DOTALL для багаторядкових збігів та IGNORECASE.
    # [^>]*? -- нежадібне порівняння будь-яких символів, крім >
    # .*? -- нежадібне порівняння тексту всередині тегу
    anchor_tag_pattern = re.compile(
        r'<a\s+[^>]*?href=["\'](?:[^"\']*?)?' + TARGET_URL_REGEX + r'(?:[^"\']*?)?["\'][^>]*?>.*?<\/a>',
        re.IGNORECASE | re.DOTALL
    )
    content = anchor_tag_pattern.sub('', content)

    # 2. Видалення згадок усередині інших атрибутів або як чистий текст
    # Видаляємо сам URL і, можливо, зайві пробіли/знаки пунктуації навколо нього (наприклад, крапку).
    plain_url_pattern = re.compile(
        r'(\s*[\.,:;]?\s*)' + TARGET_URL_REGEX + r'(\s*[\.,:;]?\s*)',
        re.IGNORECASE | re.DOTALL
    )
    # Замінюємо на порожній рядок, видаляючи також пробіли/пунктуацію
    content = plain_url_pattern.sub('', content)

    return content

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
    print("--- Запуск Скрипта Видалення Посилань ---")
    print(f"Файл логів буде збережено в: {ERROR_LOG_FILE}")
    
    total_files = 0
    modified_files = 0
    skipped_files = 0
    
    # Видаляємо старий лог-файл, щоб почати з чистого аркуша
    if os.path.exists(ERROR_LOG_FILE):
        os.remove(ERROR_LOG_FILE)

    for project_dir in PROJECT_DIRS:
        for root, dirs, files in os.walk(project_dir, topdown=True):
            # Пропускаємо службові папки
            dirs[:] = [d for d in dirs if d not in ['vendor', 'node_modules', '.git']]
            
            for file in files:
                if not file.endswith(FILE_EXTENSIONS):
                    continue

                total_files += 1
                source_path = os.path.join(root, file)
                backup_path = source_path + ".original" 
                
                # Перевірка на вже оброблені файли
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

                    # 2. ВИДАЛЕННЯ ПОСИЛАНЬ
                    modified_content = remove_link_references(original_content)
                    
                    # 3. Перевірка на зміни
                    if modified_content != original_content:
                        # 4. Запис зміненого контенту
                        with open(source_path, 'w', encoding='utf-8') as f:
                            f.write(modified_content)
                        
                        print(f"[УСПІХ] Посилання видалено та файл оновлено: {source_path}")
                        modified_files += 1
                    else:
                        print(f"[ІНФО] Посилання не знайдено. Файл не змінено. Видаляю бекап.")
                        os.remove(backup_path) # Видаляємо бекап, якщо файл не змінено
                        skipped_files += 1


                except Exception as e:
                    log_error(f"Критична помилка при обробці файлу {source_path}: {e}")
                    print(f"[КРИТИЧНА ПОМИЛКА] {e}. Див. лог.")
                    if os.path.exists(backup_path):
                        revert_file(source_path, backup_path) # Гарантуємо відновлення
                        
    print("\n--- Процес завершено ---")
    print(f"Всього файлів знайдено: {total_files}")
    print(f"Успішно змінено: {modified_files}")
    print(f"Пропущено (вже оброблені, порожні або без посилань): {total_files - modified_files}")
    print(f"Всі помилки записано в: {ERROR_LOG_FILE}")

if __name__ == "__main__":
    main()