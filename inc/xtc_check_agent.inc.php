<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_check_agent.inc.php 13149 2021-01-12 07:25:42Z GTB $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com
   (c) 2003     nextcommerce (xtc_href_link.inc.php,v 1.3 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


function xtc_check_agent($name = false) {
  if (CHECK_CLIENT_AGENT == 'true'
      && isset($_SERVER['HTTP_USER_AGENT'])
      )
  {
    $bot_array = array(
      "acme.spider",
      "adbot",
      "adsbot",
      "ahrefsbot",
      "ahoythehomepagefinder",
      "alkaline",
      "alphabot",
      "antibot",
      "appie",
      "applebot",
      "arachnophilia",
      "architext",
      "aretha",
      "ariadne",
      "arks",
      "aspider",
      "aspiegelbot",
      "atn.txt",
      "atomz",
      "auresys",
      "auskunftbot",
      "awbot",
      "backrub",
      "baidu",
      "bigbrother",
      "bingbot",
      "bitlybot",
      "bjaaland",
      "blackwidow",
      "blindekuh",
      "bloodhound",
      "bobby",
      "boris",
      "brightnet",
      "bspider",
      "bumblebee",
      "cactvschemistryspider",
      "cassandra",
      "cgireader",
      "checkbot",
      "churl",
      "cincraw",
      "cliqzbot",
      "cmc",
      "coccocbot",
      "collective",
      "combine",
      "conceptbot",
      "coolbot",
      "core",
      "cosmos",
      "crawl",
      "cruiser",
      "cscrawler",
      "cusco",
      "cyberspyder",
      "datagnionbot",
      "daviesbot",
      "deweb",
      "dienstspider",
      "digger",
      "digout4u",
      "diibot",
      "directhit",
      "discordbot",
      "dnabot",
      "domainstatsbot",
      "download_express",
      "dotbot",
      "dragonbot",
      "duckduckgo",
      "dwcp",
      "ebiness",
      "echo",
      "e-collector",
      "eit",
      "elfinbot",
      "emacs",
      "emcspider",
      "esther",
      "evliyacelebi",
      "ezresult",
      "facebookexternalhit",
      "fast-webcrawler",
      "fdse",
      "felix",
      "ferret",
      "fetchrover",
      "fido",
      "finnish",
      "fireball",
      "fouineur",
      "francoroute",
      "freecrawl",
      "funnelweb",
      "gama",
      "gazz",
      "gcreep",
      "getbot",
      "geturl",
      "gigabot",
      "gnodspider",
      "golem",
      "googlebot",
      "grapnel",
      "griffon",
      "gromit",
      "gulliver",
      "hambot",
      "harvest",
      "havindex",
      "hometown",
      "htdig",
      "htmlgobble",
      "hyperdecontextualizer",
      "ia_archiver",
      "iajabot",
      "ibm",
      "iconoclast",
      "ilse",
      "imagelock",
      "incywincy",
      "informant",
      "infoseek",
      "infoseeksidewinder",
      "infospider",
      "inspectorwww",
      "intelliagent",
      "internetseer",
      "irobot",
      "iron33",
      "israelisearch",
      "javabee",
      "jbot",
      "jcrawler",
      "jeeves",
      "jennybot",
      "jobo",
      "jobot",
      "joebot",
      "jubii",
      "jumpstation",
      "justview",
      "katipo",
      "kdd",
      "kilroy",
      "ko_yappo_robot",
      "labelgrabber.txt",
      "larbin",
      "legs",
      "linkbot",
      "linkchecker",
      "linkdexbot",
      "linkidator",
      "linkscan",
      "linkwalker",
      "lockon",
      "logo_gif",
      "lycos",
      "macworm",
      "magpie",
      "marvin",
      "mattie",
      "mediafox",
      "mercator",
      "merzscope",
      "meshexplorer",
      "mindcrawler",
      "mindupbot",
      "mj12bot",
      "moget",
      "momspider",
      "monster",
      "motor",
      "msnbot",
      "muscatferret",
      "mwdsearch",
      "myweb",
      "nativeaibot",
      "nederland.zoek",
      "netcarta",
      "netcraft",
      "netmechanic",
      "netscoop",
      "newscan-online",
      "nhse",
      "nomad",
      "northstar",
      "nzexplorer",
      "occam",
      "octopus",
      "onalyticabot",
      "openfind",
      "orb_search",
      "packrat",
      "pageboy",
      "parasite",
      "patric",
      "pegasus",
      "perignator",
      "perlcrawler",
      "perman",
      "petalbot",
      "petersnews",
      "phantom",
      "piltdownman",
      "pimptrain",
      "pinterestbot",
      "pioneer",
      "pitkow",
      "pjspider",
      "pka",
      "plumtreewebaccessor",
      "pompos",
      "pooodle",
      "poppi",
      "portalb",
      "psbot",
      "puu",
      "python",
      "qwantify",
      "raven",
      "rbse",
      "redalert",
      "researchbot",
      "resumerobot",
      "rhcs",
      "roadrunner",
      "robbie",
      "robi",
      "robofox",
      "robot",
      "robozilla",
      "roverbot",
      "rules",
      "safednsbot",
      "safetynetrobot",
      "scooter",
      "search_au",
      "searchprocess",
      "semrushbot",
      "seobilitybot",
      "senrigan",
      "serpstatbot",
      "seznambot",
      "sgscout",
      "shaggy",
      "shaihulud",
      "shoutcast",
      "sift",
      "simbot",
      "sirdatabot",
      "sitegrabber",
      "sitetech",
      "site-valet",
      "slcrawler",
      "slurp",
      "slysearch",
      "smartspider",
      "smtbot",
      "snooper",
      "solbot",
      "spanner",
      "speedy",
      "spider_monkey",
      "spiderbot",
      "spiderline",
      "spiderman",
      "spiderview",
      "spry",
      "ssearcher",
      "startmebot",
      "suke",
      "suntek",
      "surdotlybot",
      "sven",
      "tach_bw",
      "tarantula",
      "tarspider",
      "techbot",
      "telegramBot",
      "templeton",
      "teoma_agent1",
      "titan",
      "titin",
      "tkwww",
      "tlspider",
      "todoexpertosbot",
      "trendictionbot",
      "twitterbot",
      "ucsd",
      "udmsearch",
      "ultraseek",
      "unlost_web_crawler",
      "urlbot",
      "urlck",
      "validator",
      "valkyrie",
      "victoria",
      "visionsearch",
      "voila",
      "voyager",
      "vwbot",
      "w3index",
      "w3m2",
      "wallpaper",
      "wanderer",
      "wapspider",
      "webbandit",
      "webbase",
      "webcatcher",
      "webcompass",
      "webcopy",
      "webfetcher",
      "webfoot",
      "webgains",
      "weblayers",
      "weblinker",
      "webmirror",
      "webmoose",
      "webquest",
      "webreader",
      "webreaper",
      "websnarf",
      "webspider",
      "webvac",
      "webwalk",
      "webwalker",
      "webwatch",
      "wget",
      "whatuseek",
      "whowhere",
      "wired-digital",
      "wisenutbot",
      "wmir",
      "wolp",
      "wombat",
      "worm",
      "wwwc",
      "wz101",
      "xget",
      "yacybot",
      "yahoo",
      "yandex",
      "zoominfobot",
      "google-structured-data-testing-tool",
    );
    
    $user_agent_1 = strtolower($_SERVER['HTTP_USER_AGENT']);
    $user_agent_2 = strtolower(getenv("HTTP_USER_AGENT"));

    foreach ($bot_array as $bot) {
      if (strpos($user_agent_1, $bot) !== false
          || strpos($user_agent_2, $bot) !== false
          )
      {
        if ($name === true) {
          return $bot;
        }
        return 1;
      }    
    }
  }
  
  return 0;
}
?>