<?php
ini_set("display_errors", 0);
ini_set("html_errors", 1);
require 'system/template/page.class.php';

$page = new page();
$page->setup_page();
$page->set_body_content('<p>
                Lorem ipsum dolor sit <a href="#">amet</a>, consectetur adipiscing elit. Donec imperdiet lobortis pretium. Etiam dui felis, viverra at gravida nec, elementum ut purus. Aenean odio nunc, accumsan eget convallis blandit, vulputate sit amet tellus. Fusce in vulputate dui. Vestibulum non molestie sem. Cras congue, orci sit amet tincidunt rhoncus, lorem dui pellentesque purus, id mattis mi nunc eget elit. Mauris ut neque id ante pretium semper. Donec consequat pellentesque massa dignissim pretium. Mauris diam sapien, consectetur at rhoncus eget, porttitor vitae metus. Etiam convallis, est quis sagittis luctus, justo mauris cursus metus, accumsan faucibus risus sem sed felis.
                </p>
                <p>
                Morbi at ipsum velit, id tincidunt diam. Vestibulum et lectus turpis, at porta nunc. Pellentesque mauris nunc, sollicitudin et tempor at, posuere vel velit. Aenean eget sem velit, eget cursus ligula. Aenean lectus orci, condimentum eget commodo sed, ultrices in nisi. Nam pretium scelerisque lorem ac dictum. Vestibulum tortor ante, venenatis non lacinia congue, laoreet interdum nunc. Proin sodales scelerisque mauris, eu adipiscing velit accumsan eu. Cras ultricies ultricies imperdiet. Ut accumsan elementum enim at mattis. In varius diam a dui malesuada placerat.
                </p>
                <p>
                Aliquam egestas rutrum neque, sed dapibus nisi blandit ac. Fusce at nulla nulla. Nulla facilisi. Aliquam mattis malesuada augue, nec commodo nulla cursus porttitor. Nulla vel nisi purus, id dictum quam. Proin sit amet elit a nunc venenatis commodo nec in justo. Aenean nibh purus, pellentesque nec fringilla sit amet, luctus ut felis. Nullam accumsan felis ut elit feugiat sit amet pretium justo congue.
                </p>');
echo $page->get_page();

?>
