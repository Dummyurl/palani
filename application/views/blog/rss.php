<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php echo '<?xml version="1.0" encoding="utf-8" ?>'; ?>

<rss version="2.0"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
     xmlns:admin="http://webns.net/mvcb/"
     xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
     xmlns:content="http://purl.org/rss/1.0/modules/content/">

    <channel>

        <title><?php echo $feed_name; ?></title>
        <link><?php echo $feed_url; ?></link>
        <description><?php echo $page_description; ?></description>
        <dc:language><?php echo $page_language; ?></dc:language>
        <dc:creator><?php echo $creator_email; ?></dc:creator>
        <dc:rights>Copyright <?php echo gmdate("Y", time()); ?> <?php echo html_escape($settings->site_title); ?></dc:rights>

<?php foreach ($posts as $post): ?>
    <item>
        <title><?php echo $post->title; ?></title>
        <link><?php echo base_url() . "post/" . html_escape($post->title_slug); ?></link>
        <guid><?php echo base_url() . "post/" . html_escape($post->title_slug); ?></guid>
        <description><![CDATA[ <?php echo character_limiter($post->summary, 200); ?> ]]></description>
        <pubDate><?php echo $post->created_at; ?></pubDate>
        <dc:creator><?php echo html_escape($post->username); ?></dc:creator>
    </item>
<?php endforeach; ?>

    </channel>
</rss>