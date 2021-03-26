<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once('TwitterAPIExchange.php'); //include TwitterAPIExchange file


//Api key from twitter
$settings = array(
    'oauth_access_token' => "979740432857841664-31ATwG6PimbAbSGCNjEDW0JydtlAQOh",
    'oauth_access_token_secret' => "QXZ4nEhcs3dMx5TnxWCxGT8VBuhvuq3a6eWeq83nU37Gl",
    'consumer_key' => "6D8tFYT8MYiaBcfdXHZxi07SO",
    'consumer_secret' => "NJzqsx7ZP1N1V9buCtx0KBGl7ytBnhRlr571igyc4ip9I3f3Wn"
);
// link access to twitter
$url = 'https://api.twitter.com/1.1/search/tweets.json';
$requestMethod = 'GET';

//key word that we get from search.js in twitter searching part (query+conference)
$q = $_POST['q'];

$getfield = '?q='. $q;

$twitter = new TwitterAPIExchange($settings);

function renderHTML($json) {
  $sentiment = new \PHPInsight\Sentiment();

  $obj = json_decode($json);

  $html = "";
  //after getting the data as JSON, form it as html and return it to $('#list_twitter').html(data) to show in our page
  foreach($obj->statuses as $tweet) {
    $tweet_html = "";
    $tweet_html .= '<div class="col-12 twitter" style="border: 0.5px solid black; width:100%; margin-bottom:20px; padding: 20px;border-radius:10px;box-shadow: 5px 5px #888888">';
    $tweet_html .= '<h1 class="user">';
    $tweet_html .= '<img width="50px" class="profile_img" src="'. $tweet->user->profile_image_url . '" style="border-radius:50%;margin-right: 20px" />';
    $tweet_html .= '<strong>'.$tweet->user->name. '</strong></h1>';

    $tweet_text = $tweet->text;
    $scores = $sentiment->score($tweet_text);

    $tweet_html .= '<div class="row">';
    $tweet_html .= '<p>' . $tweet_text . '</p>';
    $tweet_html .= '</div>';


    $tweet_html .= '<div class="row">';

    // col-pos
    $tweet_html .= '<div class="col text-center set-center">';

    $tweet_html .= '<div class="bar">';
    $tweet_html .= '<div class="child" style="height: '. $scores['pos'] * 100 .'%"></div>';
    $tweet_html .= '</div>';

    $tweet_html .= '<p>pos: '. $scores['pos'] * 100 .'%</p>';

    $tweet_html .= '</div>';


    // end col-pos

    // col-neg
    $tweet_html .= '<div class="col text-center set-center">';

    $tweet_html .= '<div class="bar">';
    $tweet_html .= '<div class="child neg" style="height: '. $scores['neg'] * 100 .'%"></div>';
    $tweet_html .= '</div>';

    $tweet_html .= '<p>neg: '. $scores['neg'] * 100 .'%</p>';

    $tweet_html .= '</div>';

    // end col-neg

    // col-neu
    $tweet_html .= '<div class="col text-center set-center">';

    $tweet_html .= '<div class="bar">';
    $tweet_html .= '<div class="child nue" style="height: '. $scores['neu'] * 100 .'%"></div>';
    $tweet_html .= '</div>';

    $tweet_html .= '<p>neu: '. $scores['neu'] * 100 .'%</p>';

    $tweet_html .= '</div>';
    // end col-neu

    $tweet_html .= '</div>';

    $tweet_html .= '</div>';

    $html .= $tweet_html;
  }
  echo $html;
}

$res = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();

renderHTML($res); //return result as html