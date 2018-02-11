<?php
/**
 * Created by PhpStorm.
 * User: zhangjidong
 * Date: 2018/2/8
 * Time: 21:38
 */

require_once "src/api.php";

$cid = $_GET['id'];
$site = API::Site("stackoverflow");

if ($cid == null)
    $cid = 48270127;

$filter = new Filter();
$filter->SetIncludeItems('post.body');

try {
    $request =  $site->Questions($cid)->Filter($filter->GetID());
    $response = $request->Exec();
    $response = $response->Fetch(false);
} catch (APIException $e) {
    echo $e->Details();
}

var_dump($response);

$response = $request->Answers()->Exec();

$a_list = [];
while ($item = $response->Fetch(false)) {
    $a_list[] = $item;
}
var_dump($a_list);

$post = $site->Posts($cid)->Exec()->Fetch(false);
var_dump($post);


?>

