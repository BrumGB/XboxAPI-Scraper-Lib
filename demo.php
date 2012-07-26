<?php

//=============================================
// In this demo we will be collecting users
// data and displaying it like the example
// page at https://xboxapi.com/example/
//=============================================

    // include our lib
    require_once('XboxAPI_Scraper.Lib.php');

    // XboxAPI Scraper config (these may be settings you wish to change, such as debug)
    $config = array(
        'gamertag_requests' => 5,   // number of attempts to try per gamercard
        'debug' => FALSE            // are we wanting to debug?
    );

    // initize our lib
    $xapi = new XboxAPI_Scraper($config);

    // gather our profile data
    $profile = $xapi->profile('djekl');

    // do we have valid profile data
    if ( !$profile )
        die ( '<pre>' . $xapi->error() . '</pre>' );

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php print $profile->Player->Gamertag; ?>'s Profile</title>
        <link rel="stylesheet" type="text/css" href="https://github.com/necolas/normalize.css/raw/master/normalize.css">
        <style>
            html,body {
                height: 100%;
                margin: 0;
                padding: 0;
                outline: 0;

                background : url('BG.jpg') no-repeat;
                background-size: 100% 100%;
                background-attachment: fixed;
            }

            .outer {display: table;
                height: 100%;
                overflow: hidden;
                margin: 0 auto;
            }

            .inner {
                display: table-cell;
                vertical-align: middle;
            }

            .gamercard {
                border: 1px solid #bdbec1;
                padding: 10px;
                width: 600px;
                font-family: arial, sans-serif;
                font-size: 12px;
                color: #bdbec1;

                background-image: -webkit-linear-gradient(#ddd, #fff, #e9fdce);
                background-image:    -moz-linear-gradient(top, #ddd, #fff, #e9fdce);
                background-image:     -ms-linear-gradient(#ddd, #fff, #e9fdce);
                background-image:      -o-linear-gradient(#ddd, #fff, #e9fdce);
                background-image:         linear-gradient(#ddd, #fff, #e9fdce);

                -webkit-box-shadow: 0 0 8px #D0D0D0;
                   -moz-box-shadow: 0 0 8px #D0D0D0;
                        box-shadow: 0 0 8px #D0D0D0;
            }

            .gamercard img {
                display: block;
            }

            .gamercard .avatar {
                float: right;
                width: 150px;
                height: 300px;
                margin: 0px 0 0 50px;
            }

            .gamercard h1 {
                font-weight: normal;
            }

                .gamercard h1 img {
                    display: inline-block;
                    padding-right: 10px;
                    width: 64px;
                    height: 64px;
                }

                .gamercard h1 a {
                    text-decoration: none;
                }

                    .gamercard h1 a:hover {
                        background: #bbe6a6;
                        color: #333;
                    }

            .gamercard h2 {
                color: #111;
                font-size: 16px;
                font-weight: normal;
                margin-top: 15px;
            }

            .gamercard ul {
                list-style-type: none;
            }
                .gamercard ul li {
                    padding-top: 8px;
                }

                    .gamercard ul li strong {
                        color: #666;
                    }

            .gamercard ul.games li {
                display: inline-block;
                margin-right: 20px;
                text-align: center;
                font-weight: bold;
                width: 85px;
                vertical-align: top;
            }
                .gamercard ul.games li img {
                    margin: 0 auto;
                    width: 85px;
                }

            .gamercard a {
                color: #78bb58;
            }

            .gamercard .clear {
                clear: both;
            }

            .boxArt {
                border: 1px solid #D0D0D0;

                -webkit-box-shadow: 0 0 8px #D0D0D0;
                   -moz-box-shadow: 0 0 8px #D0D0D0;
                        box-shadow: 0 0 8px #D0D0D0;

                background-image: url('BoxArtNotFound.jpg');
            }

            .userInfo {
                white-space: nowrap;
            }

            .gameInfo {
                white-space: pre-wrap;
            }
        </style>
    </head>
    <body>
        <div class="outer">
            <div class="inner">
                <!-- gamercard -->
                <div class="gamercard">

                    <!-- profile image -->
                    <img src="<?php print $profile->Player->Avatar->Body; ?>" alt="<?php print $profile->Player->Gamertag; ?>" class="avatar" />

                    <!-- gamer name -->
                    <h1><img src="<?php print $profile->Player->Avatar->Gamertile->Large; ?>" alt="<?php print $profile->Player->Gamertag; ?>" /><a href="https://live.xbox.com/en-US/Profile?gamertag=<?php print $profile->Player->Gamertag; ?>"><?php print $profile->Player->Gamertag; ?></a></h1>

                    <!-- personal info -->
                    <h2>User Info</h2>
                    <ul>
                        <li class='userInfo'><strong>Name:</strong> <?php print $profile->Player->Name; ?></li>
                        <li class='userInfo'><strong>Bio:</strong> <?php print str_replace('\n', "\n<br />\n", $profile->Player->Bio); ?></li>
                        <li class='userInfo'><strong>Location:</strong> <?php print $profile->Player->Location; ?></li>
                        <li class='userInfo'><strong>Motto:</strong> <?php print $profile->Player->Motto; ?></li>
                        <li class='userInfo'><strong>Online:</strong> <?php print $profile->Player->Status->Online ? "Online" : "Offline"; ?></li>
                        <li class='gameInfo'><strong>Status:</strong> <?php print $profile->Player->Status->Online_Status; ?></li>
                    </ul>

                    <!-- recent games -->
                    <h2>Recent Games</h2>
                    <ul class="games">
                        <?php foreach($profile->RecentGames as $Game): ?>
                             <li>
                                <a href="<?php print $Game->MarketplaceURL; ?>">
                                    <img
                                        class="boxArt"
                                        lowsrc="BoxArtNotFound.jpg"
                                        src="<?php print $Game->BoxArt->Small; ?>"
                                        alt="<?php print $Game->Name; ?>"
                                        height="120"
                                        width="85"
                                    />
                                </a>
                                <br />
                                <?php print $Game->Name; ?>
                             </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </body>
</html>