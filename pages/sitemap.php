<?php
header("Content-type: text/xml");
echo "<?xml version='1.0' encoding='UTF-8'?>";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?php
include '../session.php';
$sql = query("/*qc=on*/ SELECT Members.Nick, Posts.id FROM Posts JOIN Members ON Members.id = Posts.user");
while ($string = mysqli_fetch_array($sql)){?>
    <url>
        <loc>https://tras.pw/post/<?php echo $string['Nick']."/".$string['id']; ?></loc>
        <changefreq>weekly</changefreq>
    </url>
<?php }
$sql = query("/*qc=on*/ SELECT Nick FROM Members");
while ($string = mysqli_fetch_array($sql)){?>
    <url>
        <loc>https://tras.pw/user/<?php echo $string['Nick']; ?></loc>
        <changefreq>weekly</changefreq>
    </url>
<?php } ?>
</urlset>