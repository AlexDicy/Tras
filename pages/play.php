<?php $logButton = $i ? '<a href="https://tras.pw/page/logout" class="btn btn-default" role="button">Logout</a>' : '<a href="https://tras.pw/page/login" class="btn btn-primary" role="button">Login</a>'; ?>
<!DOCTYPE html>
<head>
    <title><?php echo $title ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="robots" content="index, follow">
    <meta name="description" content="Eat, eat, eat and grow up! Get new levels and XP!">
    <meta name="viewport" content="minimal-ui, width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@TrasGames">
    <meta name="twitter:title" content="Tras">
    <meta name="twitter:description" content="Eat, eat, eat and grow up! Get new levels and XP!">
    <meta name="twitter:creator" content="@TrasGames">
    <meta property="og:title" content="Tras">
    <meta property="og:description" content="Eat, eat, eat and grow up! Get new levels and XP!">
    <meta property="og:url" content="https://tras.pw">
    <meta property="og:image" content="https://tras.pw/assets/images/social.png">
    <meta property="og:image:width" content="1440">
    <meta property="og:image:height" content="891">
    <meta property="og:type" content="website">
    <meta property="fb:app_id" content="198347767255916">
    <link id="favicon" rel="icon" type="image/png" href="assets/images/tras_logo_32.png" sizes="32x32">
    <link id="favicon" rel="icon" type="image/png" href="assets/images/tras_logo_128.png" sizes="128x128">
    <link href="https://fonts.googleapis.com/css?family=Lalezar" rel="stylesheet" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" class="ng-scope">
    <link href="//tras.pw/assets/styles/tras.css" rel="stylesheet">
    <link href="//tras.pw/assets/styles/game.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//tras.pw/js.cookie.js"></script>
    <script src="//tras.pw/engine.js"></script>
    <script src="//tras.pw/main.js?76"></script> 
</head>
<body>    
    <div id="fb-root"></div>
        <div id="overlays" style="display:none; position: absolute; left: 0; right: 0; top: 0; bottom: 0; background-color: rgba(0,0,0,0.5); z-index: 200;">
            <div id="panel">
                <div id="left" class="subpanel">
                    <div class="row">
                        <div class="col-sm-6 profile">
                            <div class="thumbnail clearfix">
                                <?php if ($i && !$_SESSION['info']['Confirmed']) { ?><div class="alert alert-success"><strong>Info</strong> We sent you a confirmation email</div><?php } ?>
                                <img class="profile-photo" src="<?php echo $avatar ?>" style="border-radius: 5px;" alt="Profile Photo">
                                <div class="caption" style="padding-top: 2px;padding-bottom: 14px;">
                                    <h4 style="margin-top: -2px;margin-bottom: 0px;"><strong><?php echo $nickname ?></strong></h4>
                                    <p style="max-width: 214px;">We are working on accounts system.</p>
                                </div>
								<p style="float: left; margin: 4px 0 0 0;"><?php echo $logButton ?></p>
                            </div>
                        </div>
                    </div>
					<div id="leftAd">
                        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js" onerror="showImg();"></script>
                        <!-- Tras.pw 300x250 -->
                        <ins class="adsbygoogle"
                            style="display:inline-block;width:300px;height:250px"
                            data-ad-client="ca-pub-8086066615009128"
                            data-ad-slot="5460067292"></ins>
					</div>
                </div>
			<div id="main" class="subpanel">
                <form role="form">
                    <div class="form-group">
                        <div style="float: left; margin-left: 0px;">
                            <h2>Tras</h2>
                        </div>
                        <div class="fb-like" style="float: right; margin-top: 30px;" data-href="http://tras.pw" data-layout="button" data-action="like" data-show-faces="true" data-share="true"></div>
                        <br clear="both" />
                    </div>
                    <div class="form-group">
                        <select id="gamemode" class="form-control" onchange="setGameMode($(this).val());">
                            <option selected value="Default">Default</option>
                            <option value="Teams">Teams</option>
                            <option value="Experimental">Experimental</option>
                        </select>
                        <input id="nick" class="form-control save" data-box-id="0" formnovalidate autocomplete="off" placeholder="Nick" maxlength="15" onchange="nickChange(this);" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"/>
                        <br clear="both"/>
                    </div>
                    <div id="locationUnknown">
                        <select id="region" class="form-control" onchange="setRegion($('#region').val());" required>
                            <option selected value="EU-Germany">Europe</option>
                        </select>
                    </div>
                    <div>
                        <div class="text-muted region-message CN-China">
                        </div>
                    </div>
                    <div class="form-group">
                        <button disabled type="submit" id="playBtn" onclick="setNick(document.getElementById('nick').value); return false;" class="btn btn-play btn-primary btn-needs-server">Play</button>
                        <button id="disconnectBtn" onclick="disconnect(); return false;" class="btn btn-disconnect btn-danger" style="display: none;">Disconnect</button>
                        <button id="toggleSettings" class="btn btn-info btn-settings"><i class="glyphicon glyphicon-cog"></i></button>
                        <br clear="both" />
                    </div>
                    <div id="settings" class="checkbox" style="display: none;">
                        <div class="form-group" id="mainform">
                            <div id="locationKnown"></div>
                            <button id="spectateBtn" onclick="spectate(); return false;" disabled class="btn btn-warning btn-spectate btn-needs-server">Spectate</button>
                            <br clear="both" />
                        </div>
                    </div>
                </form>
                <div id="instructions">
                    <hr/>
                    <center><span class="text-muted">
        <strong>Space</strong> to fire mass</br>
        <strong>F</strong> to fire bullets</br>
        <strong>S</strong> to split</br>
        </br>
        You can have max 18 cells and 10 bullets
        </span>
                    </center>
                </div>
                <hr/>
                <center>
        
                    <center>
                        <span class="text-muted">
            </span>
                    </center>
                    <div>
                    </div>
                    <small class="text-muted text-center"></small>
                </center>
                <hr style="margin-bottom: 7px; " />
                <div style="margin-bottom: 5px; line-height: 32px; margin-left: 6px; height: 32px;">
                    <center>
                        <a href="privacy" class="text-muted">Privacy</a> |
                        <a href="tos" class="text-muted">Terms of Service</a> |
                        <a href="changelog" class="text-muted">Changelog</a>
                    </center>
                </div>
        
            </div>
		    <div id="right" class="subpanel">
                <div class="alert alert-info hidden" style="margin-top: 10px;"><strong>Info</strong> Blablabla lol.</div>
                <h4>Settings</h4>
                <div class="switch">
                    <label>
                    <input type="checkbox" class="save" data-box-id="1" onchange="setShowMass($(this).is(':checked'));">
                    <span class="lever"></span>
                    Show mass
                    </label>
                </div>
                <div class="switch">
                    <label>
                    <input type="checkbox" class="save" data-box-id="2" onchange="setSkins($(this).is(':checked'));">
                    <span class="lever"></span>
                    No skins
                    </label>
                </div>
                <div class="switch">
                    <label>
                    <input type="checkbox" class="save" data-box-id="3" onchange="setNames($(this).is(':checked'));">
                    <span class="lever"></span>
                    No names
                    </label>
                </div>
                <div class="switch">
                    <label>
                    <input type="checkbox" class="save" data-box-id="4" onchange="setBlueTheme($(this).is(':checked'));">
                    <span class="lever"></span>
                    Blue theme
                    </label>
                </div>
                <div class="switch">
                    <label>
                    <input type="checkbox" class="save" data-box-id="5" onchange="setGrayScale($(this).is(':checked'));">
                    <span class="lever"></span>
                    GrayScale
                    </label>
                </div>
                <div class="switch">
                    <label>
                    <input type="checkbox" class="save" data-box-id="6" onchange="setChatHide($(this).is(':checked'));">
                    <span class="lever"></span>
                    Hide chat
                    </label>
                </div>
                <div class="switch">
                    <label>
                    <input type="checkbox" class="save" data-box-id="7" onchange="setLessLag($(this).is(':checked'));">
                    <span class="lever"></span>
                    Less Lag
                    </label>
                </div>
            </div>
        </div>
	</div>
    <div id="loading" style="display:none;position: absolute; left: 0; right: 0; top: 0; bottom: 0; z-index: 100; background-color: rgba(0,0,0,0.5);">
        <div style="color: #FFF; width: 400px; background-color: transparent; margin: 100px auto; padding: 5px 15px 5px 15px;">
            <h2>Loading</h2>
            <p> If you have problems connecting, check if your antivirus or firewall is blocking the connection.
        </div>
    </div>
    <div style="font-family:'Lalezar'" class="ng-scope">&nbsp;</div>
    <canvas id="canvas" width="800" height="600"></canvas>
    <input type="text" id="chat_textbox" maxlength="200" placeholder="Press Enter to chat" />  
    <div style="font-family:'Lalezar'">&nbsp;</div> 
    <script type="text/javascript">
        $('input').keypress(function(e) {
            if (e.which == '13') {
                e.preventDefault();
                if (!isSpectating) setNick(document.getElementById('nick').value);
            }
        });
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=198347767255916";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        $("title").text("Tras");
    </script>
</body>
