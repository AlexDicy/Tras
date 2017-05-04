<?php
header("Content-type: text/xml");
?>
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?php
$file = "./sitemap.xml";
if (!file_exists($file) || filemtime($file) < time() - 3600) {
    $content;
    ob_start();
    $sql = query("/*qc=on*/ SELECT Members.nick, Posts.id FROM Posts JOIN Members ON Members.id = Posts.user");
    while ($string = mysqli_fetch_array($sql)) {
?>
    <url>
        <loc>https://tras.pw/post/<?php echo $string['nick']."/".$string['id']; ?></loc>
        <changefreq>weekly</changefreq>
    </url>
<?php
    }
    $sql = query("/*qc=on*/ SELECT nick FROM Members");
    while ($string = mysqli_fetch_array($sql)) {
?>
    <url>
        <loc>https://tras.pw/user/<?php echo $string['nick']; ?></loc>
        <changefreq>weekly</changefreq>
    </url>
<?php
    }
    $content = ob_get_clean();
    file_put_contents($file, $content);
    echo $content;
} else {
    echo file_get_contents($file);
}
?>
</urlset>