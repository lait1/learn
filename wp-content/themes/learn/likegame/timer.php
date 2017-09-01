<div id="timer_i1"></div>
<?php
$fx_date = explode('.', '22.10.2015');
$fx_timer_date = mktime(0, 0, 0, $fx_date[1], $fx_date[0], $fx_date[2]);
?>
<script>
    (function () {
        var _id = "_i1";
        //document.write("<div id='timer" + _id + "' style='min-width:482px;height:103px;'></div>");
        var _t = document.createElement("script");
        _t.src = "<?php bloginfo('template_directory') ?>/js/timer.min.js";
        var _f = function (_k) {
            var nowdate=new Date();
            var tz=nowdate.getTimezoneOffset()/60*-1;
            var l = new MegaTimer(_id, {
                "view": [0, 1, 1, 1],
                "type": {
                    "currentType": "2",
                    "params": {"usertime": false, "tz": tz, "utc": <?php echo $GLOBALS['fx_timer_time'] ?>000}
                    /*"params": {"startByFirst": true, "days": "0", "hours": "<?php echo 2+rand(0,2) ?>", "minutes": "<?php echo rand(1,59) ?>", "utc": 0}*/
                },
                "design": {
                    "type": "plate",
                    "params": {
                        "round": "4",
                        "background": "solid",
                        "background-color": "#000",
                        "effect": "flipchart",
                        "space": "4",
                        "separator-margin": "12",
                        "number-font-family": {
                            "family": "Open Sans Condensed",
                            /*"link": "<link href='http://fonts.googleapis.com/css?family=Comfortaa&subset=latin,cyrillic' rel='stylesheet' type='text/css'>"*/
                        },
                        "number-font-size": "38",
                        "number-font-color": "#ffffff",
                        "padding": "7",
                        "separator-on": false,
                        "separator-text": ":",
                        "text-on": true,
                        "text-font-family": {"family": "Open Sans Condensed"},
                        "text-font-size": "16",
                        "text-font-color": "#000"
                    }
                },
                "designId": 3,
                "theme": "black",
                "width": 482,
                "height": 103
            });
            if (_k != null)l.run();
        };
        _t.onload = _f;
        _t.onreadystatechange = function () {
            if (_t.readyState == "loaded")_f(1);
        };
        var _h = document.head || document.getElementsByTagName("head")[0];
        _h.appendChild(_t);
    }).call(this);

</script>