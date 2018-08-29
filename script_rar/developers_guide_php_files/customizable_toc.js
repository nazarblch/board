// Copyright 2009 Google, All Rights Reserved.

/**
* @fileoverview This JavaScript file enables users to customize documentation
*               using an adviser. Based on the options that the user selects in
*               in the adviser, the JS customizes the left nav and pagination
*               links. It also modifies links throughout the document to ensure
*               that the user stays within the customized document set.
*
* @author Andy Diamondstein
*/

(function() {
  // Map of numbers used to calculate cookie value to documents
  var cookieMap = new Array();

  // Array in which the key is an <li> element and the value is the
  // parent <li> element, if there is one
  var parent = new Array();

  // Array that identifies list items that have children
  var hasKids = new Array();

  // Array that identifies menus in which we want to show all children
  // regardless of adviser entry
  var showKids = new Array();

  // Cookie path, prefix for URL values and service string for cookie value
  var cookiePath = '/';
  var urlPrefix = '';
  var serviceString = '';

  // Node name that the user is on
  var docsetLocation = '';

  // Array of everything that is displayed in the TOC
  var showLink = new Array();

  // Link text associated with an <li> element
  var linkText = new Array();

  // List of TOC links to exclude from pagination
  var paginationLinksToExclude = new Array();

  // Order of links in the TOC ... used in pagination
  var linkOrder = new Array();
  var linkCount = 1;

  // Flag to indicate whether the page displays a customized document set
  cookie = readCookie('codesitedp' + serviceString);

  // Custom TOC cookie value
  var cookiePrefs = new Object;

  // Flag to indicate whether user is on the adviser page
  // Looking to see whether the last 12 chars of the filename are "adviser.html"
  var adviserPage = 0;
  if (location.pathname.match(/adviser.html$/)) {
    adviserPage = 1;
  }

  /**
   * The 'traverseTOC' function builds a list of links in the left nav
   * and keeps track of the parent and child elements for each of those links
   * in the "global" variables hasKids, linkOrder and parent
   * @param {string|Object} tocNode Mandatory This argument identifies a node in
                                    the left nav to check for child nodes.
   * @param {string} opt_lastParent Optional This argument identifies
   *                                the most recently identified parent node by
   *                                its ID value.
   */
  function traverseTOC(tocNode, opt_lastParent) {
    // toc is the object that corresponds to the left nav node being checked
    var toc;
    if (typeof(tocNode) == 'string' &&
        (toc = document.getElementById(tocNode))) {
      opt_lastParent = tocNode;
    } else {
      toc = tocNode;
    }

    // Walk through the left nav tree to identify the child nodes
    // for each parent node (and the parent for every child).
    var i = 0;
    var child;
    while (child = toc.childNodes[i]) {
      if (child.nodeName == 'UL') {
        opt_lastParent = toc.id;
        // If the node is a 'ul' tag, create an array of its child nodes
        hasKids[opt_lastParent] = new Array();
      }
      if (child.id) {
        // Track the order in which nodes appear
        linkOrder[linkCount] = child.id;
        linkOrder[child.id] = linkCount++;

        // Add the child node to the array of the parent node's children
        hasKids[opt_lastParent].push(child.id);

        // Keep track of each child node's parent
        parent[child.id] = opt_lastParent;
      }

      // If the node has children, run this function on the node as well
      if (child.hasChildNodes()) {
        traverseTOC(child, opt_lastParent);
      }
      i++;
    }
  }

  /**
   * The 'setOrDropCookie' function sets a cookie if the URL contains
   * "&toc-docset=###", which identifies docs to show, or "&toc-customized=on",
   * which indicates new preferences were just set. It drops any existing cookie
   * if the URL contains '&toc-customized=clear', indicating preferences were
   * just canceled.
   */
  function setOrDropCookie() {

    if (cookieString = getParam('toc-docset')) {
      // User has a link to this document set.
      // TODO: Set service string dynamically for saved links
      setServiceString('ytapiv2');
      createCookie('codesitedp' + serviceString,
          cookieString, 365);

    } else if (getParam('toc-customized') === 'on') {
      // User just customized the document set.
      // convert query params to cookie string of 0s and 1s
      cookieString = convertQueryParams();
      createCookie('codesitedp' + serviceString,
          cookieString, 365);

    } else if (getParam('toc-customized') === 'clear') {
      // User just cleared cookie preferences
      createCookie('codesitedp' + serviceString, '', -1);
    }
    cookie = readCookie('codesitedp' +
        serviceString);
  }

  /**
   * The 'convertQueryParams' function converts the options that the user
   * selected into a cookie value. To calculate the value, the function uses
   * the TOC's cookieMap, which assigns a number to each document.
   * The numbers begin with 1 and ascend. Each new document needs a new number,
   * but numbers do not need to match the order that the documents are listed.
   * For each displayed document:
   *     cookie value += 2^(key from cookieMap - 1)
   * So, if the first document is shown and the fourth document is shown, the
   * cookie value would be 9 -- (2^0 + 2^3);
   * @return {string} The cookie value, which identifies the selected options.
   */
  function convertQueryParams() {
    var cookieMapKeyCount = 0;
    var cookieValue = 0;
    for (key in cookieMap) {
      if (getParam(cookieMap[key])) {
        cookieValue += Math.pow(2, cookieMapKeyCount);
      }
      cookieMapKeyCount++;
    }
    return cookieValue;
  }

  /**
   * The 'setCookiePrefs' function checks each digit in the binary cookie
   * value and sets a flag to display each document flagged in the cookie.
   * The position of the cookie digit corresponds to a key in cookieMap.
   */
  function setCookiePrefs() {
    if (cookie != null) {
      for (var pos = 1; pos <= cookie.length; pos++) {
        // pos = 1 equals cookieMap[1] equals last digit in binary
        // string (2^0) and is identified by charAt(cookie.length - pos)
        var checkValue = cookie.charAt(cookie.length - pos);
        if (checkValue == '1') {
          cookiePrefs[cookieMap[pos]] = 1;
        }
      }
    }
  }

  /**
   * The 'createCookie' function drops a cookie on the user's machine.
   * @param {string} keyName Mandatory A value to uniquely identify the cookie.
   * @param {string} keyValue Mandatory The value of the cookie. Before the
   *                                    cookie is saved, the value is converted
   *                                    to a base 10 number to shorten the
   *                                    length of the cookie value.
   * @param {number} noOfDays Optional How many days the cookie will be valid.
   */
  function createCookie(keyName, keyValue, noOfDays) {
    var expires = '';
    if (noOfDays > 0) {
      var date = new Date();
      date.setTime(date.getTime() + (noOfDays * 24 * 60 * 60 * 1000));
      expires = '; expires=' + date.toGMTString();
    } else if (noOfDays < 0) {
      var date = new Date();
      date.setTime(date.getTime());
      expires = '; expires=' + date.toGMTString();
    } else {
      expires = '';
    }
    document.cookie = keyName + '=' + keyValue + expires + 
        '; path=' + cookiePath;
  }

  /**
   * The 'readCookie' function reads a cookie from the user's machine if the
   * cookie exists. Before returning the cookie value, the function converts the
   * cookie value to binary format. If the cookie does not exist, the function
   * returns null.
   * @param {string} keyName Mandatory A unique identifier for the cookie.
   * @return {string} The cookie value, which identifies the selected options.
   */
  function readCookie(keyName) {
    var start = document.cookie.indexOf(keyName + '=');
    var len = start + keyName.length + 1;
    if (!start && keyName != document.cookie.substring(0, keyName.length)) {
      return null;
    }
    if (start == -1) {
      return null;
    }
    var end = document.cookie.indexOf(';', len);
    if (end == -1) {
      end = document.cookie.length;
    }

    var cookieValue = document.cookie.substring(len, end);

    // Convert the cookie value to a binary value.
    var base10CookieValue = parseInt(cookieValue, 10);
    var binaryCookieValue = base10CookieValue.toString(2);
    return binaryCookieValue;
  }

  /**
   * The 'displayTOCLinks()' function enforces these display rules:
   * <ol>
   *   <li>If tag 'X' is explicitly displayed, and tag 'Y' is a child of 'X',
   *       then we show tag 'Y' regardless of whether tag 'Y' is also explicitly
   *       displayed. For example, if the query params indicate that the
   *       authentication section is displayed (toc-authentication=on) and
   *       the AuthSub page (toc-authsub) is a child of the Authentication page,
   *       then we display (toc-authsub) even if toc-authsub=on is not present.
   *   <li>If a query param does not exist to show a node, then we hide it. To
   *       follow on the previous example, if 'toc-authentication=on' is not
   *       present (condition 1 is false), and 'toc-authsub=on' is also not
   *       present, then the AuthSub node will be hidden in the left nav.
   *   <li>If a query param has a parent, show the parent. So, if
   *       'toc-authentication=on' is not present (condition 1 is false) and
   *       'toc-authsub=on' is present (condition 2 is false), then display the
   *       link to the Authentication page (toc-authentication) even though it
   *       isn't explicitly selected since AuthSub is a child of Authentication.
   * </ol>
   */
  function displayTOCLinks() {
    var count = 1;
    while (linkOrder[count]) {
      // If user is on the adviser page and not editing previous selections --
      // i.e. starting from scratch -- just show the top-level link.
      if (adviserPage == 1 && cookie == null &&
          (linkOrder[count] == 'toc-audience')) {
        tocItem = document.getElementById(linkOrder[count]);
        showLink[linkOrder[count]] = 1;
        tocItem.style.display = 'block';

      // If user is not on the adviser page and not looking at a customized
      // document set, then show everything.
      } else if (adviserPage == 0 && cookie == null &&
          (linkOrder[count] != 'toc-customized')) {
        tocItem = document.getElementById(linkOrder[count]);
        showLink[linkOrder[count]] = 1;
        tocItem.style.display = 'block';

      // Otherwise check the node more closely.
      } else if (tocItem = document.getElementById(linkOrder[count])) {

        // Check whether the cookie says to display the node or its parent
        thisCookiePref = cookiePrefs[linkOrder[count]];
        parentCookiePref =
            cookiePrefs[parent[linkOrder[count]]];

        // Check for a URL query param for the node or its parent
        thisLinkParam = getParam(linkOrder[count]);
        parentLinkParam =
            getParam(parent[linkOrder[count]]);

        // If there's a cookie preference or a query param for the node's
        // parent node, show the node.
        if (parentCookiePref ||
            (parentLinkParam != null && parentLinkParam != '')) {
          tocItem.style.display = 'block';
          showLink[linkOrder[count]] = 1;
          showLink[parent[linkOrder[count]]] = 1;

        // If there's not a query param for the node, then don't show it.
        } else if (!thisCookiePref &&
            (thisLinkParam == null || thisLinkParam == '')) {
          tocItem.style.display = 'none';

        // Otherwise, we show the node. So, if it has a parent, show the parent.
        } else if (parent[linkOrder[count]]) {
          var parentTOCItem =
              document.getElementById(
                  parent[linkOrder[count]]);
          parentTOCItem.style.display = 'block';
          showLink[parent[linkOrder[count]]] = 1;
          showLink[linkOrder[count]] = 1;

        // We're showing the node and it doesn't have a parent.
        } else {
          showLink[linkOrder[count]] = 1;
        }
      }
      count++;
    }
  }

  /**
   * The 'showIfShown' function ensures that if a link to document X is
   * displayed, then the link to document Y will also be displayed even if
   * document Y is not explicitly selected. For example, in the YouTube API
   * documentation, we want to show the 'Checking Video Status' link if the
   * 'Uploading Videos' link is also shown.
   * @param {string} ifShown Mandatory This parameter identifies the node in the
   *                                   left nav that is being checked. If this
   *                                   node is displayed, then the thenShow node
   *                                   should also be displayed.
   * @param {string} thenShow Mandatory This parameter identifies the node to
   *                                    display if the 'ifShown' node is also
   *                                    displayed.
   */
  function showIfShown(ifShown, thenShow) {
    if (showLink[ifShown]) {
      tocItem = document.getElementById(thenShow);
      showLink[thenShow] = 1;
      tocItem.style.display = 'block';
    }
  }

  /**
   * The 'setServiceString' function sets a string that is part of the
   * cookie name, enabling the code to set different cookies for different
   * document sets.
   * @param {string} service Mandatory String used in the cookie name.
   */
  function setServiceString(service) {
    serviceString = service;
  }

  /**
   * The 'setCookiePath' function sets the cookie path to the base URL of the
   * table of contents. For example, if the TOC is located at
   * '/apis/youtube/_toc.ezt', then the cookiePath is '/apis/youtube/'.
   * @param {string} path Mandatory The path for the cookie.
   */
  function setCookiePath(path) {
    cookiePath = path;
  }

  /**
   * The 'setUrlPrefix' function sets a prefix that is prepended to left
   * nav node names to create URLs in the document set. For example, if the
   * URL prefix is 'developers_guide_protocol_' and the node name is
   * 'toc-authsub', then the file is 'developers_guide_protocol_authsub.html'.
   * (The 'toc-' portion of the node name is stripped when creating the URL.)
   * @param {string} prefix Mandatory The prefix for TOC URLs in this doc set.
   */
  function setUrlPrefix(prefix) {
    urlPrefix = prefix;
  }

  /**
   * The 'hideEmptyParents' function ensures that if none of the child
   * nodes for a parent node display, then the parent node is also hidden in the
   * left nav. For example, in the YouTube API, developers can opt to display
   * information about several community features -- comments, ratings, video
   * responses, etc. If the developer does not display information about any of
   * those features, then the 'Community Features' node in the left nav is also
   * hidden.
   */
  function hideEmptyParents() {
    // If user is on the adviser page and starting from scratch, just exit. On
    // the adviser page for a new user, we show the top-level link.
    if (adviserPage == 1 && cookie == null) {
      return;
    }

    // Otherwise, for each node that has children ...
    for (var c in hasKids) {
      if (c == null || c == '') {
        continue;
      }

      // By default, assume we'll hide the parent node
      var style = 'none';

      // If the page shows all children of the parent node, display the node
      if (showKids[c]) {
        style = 'block';

      // Otherwise, if any child of the parent node is displayed, then also
      // display the parent.
      } else {
        for (var hcc in hasKids[c]) {
          var childTOCItem =
            document.getElementById(hasKids[c][hcc]);
          if (childTOCItem.style.display != 'none') {
            style = 'block';
            break;
          }
        }
      }
      document.getElementById(c).style.display = style;
    }
  }

  /**
   * The 'getParam' function retrieves a parameter value from the URL.
   * This is the same function that AdSense for Search (AFS) JS partners use.
   * @param {string} name Mandatory The name of the URL parameter.
   * @return {string?} The parameter value for a specific parameter, if the
   *                       value exists. If the parameter is not present, the
   *                       function returns a null value.
   */
  function getParam(name) {
    var match = new RegExp(name + '=*([^&]+)*', 'i').exec(location.search);
    if (match == null) {
      match = new RegExp(name + '=(.+)', 'i').exec(location.search);
    }
    if (match == null) {
      return null;
    }

    // convert match to a string
    match = match + '';
    result = match.split(',');
    if ((resultSubstr = result[1].substr(0, 3)) == '%3D') {
      result[1] = result[1].substr(3);
    }
    return decodeURIComponent(result[1]);
  }

  /**
   * The 'getLinkTextFromNavLinks' function retrieves the link text for
   * each left nav node. The link text is used in next/previous page links.
   */
  function getLinkTextFromNavLinks() {
    for (var sl in showLink) {
      if (sl != '' && sl != null && (tocItem = document.getElementById(sl))) {
        var i = 0;
        var child;
        while (child = tocItem.childNodes[i]) {
          if (child.nodeName == 'A') {
            if (child.text != null && child.text != '' &&
                child.text != 'undefined') {
              linkText[sl] = child.text;
            } else {
              linkText[sl] = child.innerText;
            }
            break;
          }
          i++;
        }
      }
    }
  }

  /**
   * The 'overrideLinkText' function overrides the link text for a node
   * to use something other than what the 'getLinkTextFromNavLinks()
   * function identified for that node. For example, in the YouTube guide,
   * 'Developer's Guide &lt;sup&gt;2.0&lt;/sup&gt;' is captured as '2.0'
   * without the 'Developer's Guide'.
   * @param {string} nodeName Mandatory This parameter identifies the node that
   *                                    is having its link text changed.
   * @param {string} linkText Mandatory This parameter identifies the new link
   *                                    text for the node.
   */
  function overrideLinkText(nodeName, newLinkText) {
    if (nodeName && newLinkText) {
      linkText[nodeName] = newLinkText;
    }
  }

  /**
   * The 'setDocsetLocation' function retrieves the current page URL by
   * determining which left nav node the user is looking at. Based on that
   * information, the JavaScript can generate next page and previous page links.
   */
  function setDocsetLocation() {
    // Get the node name for the page the user is on. The node name is the
    // portion of the filename between the urlPrefix and '.html'. For example,
    // if the page is developers_guide_protocol_authsub.html, and the urlPrefix
    // is 'developers_guide_protocol_', then the node name is 'authsub'.
    var match =
        new RegExp(urlPrefix + '([^\.]+)', 'i').exec(location.href);

    // convert match to a string
    match = match + '';
    result = match.split(',');
    docsetLocation = result[1];
  }

  /**
   * The 'getPageLinkTitle' function formats the display title for
   * next and previous page links.
   * @param {string} linkUrl Mandatory This parameter identifies the node that
   *                                   the function is getting link text for.
   * @return {string?} The name of the document identified by a previous or
   *                       next page link. If the document name could not be
   *                       determined, then the function returns a null value.
   */
  function getPageLinkTitle(linkUrl) {
    if (linkText[linkUrl]) {
      return '<span style=\"color:#333;font-size:83%\">(' +
        linkText[linkUrl] + ')</span>';
    } else {
      return '';
    }
  }

  /**
   * The 'writePreviousPageInfo' function writes a link to the
   * previous page in the document set. It works on both customized and
   * uncustomized document sets.
   */
  function writePreviousPageInfo() {
    // Go backward from this spot to find the document with the highest sort
    // order that is displayed but that still displays before this document.
    if (linkOrder['toc-' + docsetLocation]) {
      var previousSortOrder = linkOrder['toc-' + docsetLocation];
      previousSortOrder--;
      for (var pso = previousSortOrder; pso > 0; pso--) {
        if (paginationLinksToExclude[linkOrder[pso]]) {
          previousSortOrder--;
        } else if (showLink[linkOrder[pso]] &&
            linkText[linkOrder[pso]]) {
          break;
        } else {
          previousSortOrder--;
        }
      }
      if (linkOrder[previousSortOrder]) {
        document.write('<a href=\"' + urlPrefix +
            linkOrder[previousSortOrder].replace(/toc-/, '') +
            '.html\">&laquo;&nbsp;Previous</a><br/>' +
            getPageLinkTitle(linkOrder[previousSortOrder]));
      }
    }
  }

  /**
   * The 'writeNextPageInfo' function writes a link to the next page in the
   * document set. It works on both customized and uncustomized document sets.
   */
  function writeNextPageInfo() {
    // Go forward from this spot to find the document with the highest sort
    // order that is displayed (and that displays after this document).
    if (linkOrder['toc-' + docsetLocation]) {
      var nextSortOrder = linkOrder['toc-' + docsetLocation];
      nextSortOrder++;
      for (var nso = nextSortOrder; nso < linkOrder.length; nso++) {
        if (paginationLinksToExclude[linkOrder[nso]]) {
          nextSortOrder++;
        } else if (cookie == null &&
            linkText[linkOrder[nso]]) {
          break;
        } else if (showLink[linkOrder[nso]] &&
            linkText[linkOrder[nso]]) {
          break;
        } else {
          nextSortOrder++;
        }
      }
      if (linkOrder[nextSortOrder]) {
        document.write('<a href=\"' + urlPrefix +
            linkOrder[nextSortOrder].replace(/toc-/, '') +
            '.html\">Next&nbsp;&raquo;</a><br/>' +
            getPageLinkTitle(linkOrder[nextSortOrder]));
      }
    }
  }

  /**
   * The 'excludePaginationLink' function lets you specify links in the TOC
   * that should not be included in pagination links.
   * @param {string} excludePaginationLink Mandatory The TOC link to exclude.
   */
  function excludePaginationLink(excludePaginationLink) {
    paginationLinksToExclude[excludePaginationLink] = 1;
  }

  /**
   * Show 'Customized!' message if the user is looking at customized doc set
   */
  function showCustomizedDocMessage() {
    if (cookie != null) {
      var messageNode = document.getElementById('customized-doc-message');
      if (messageNode) {
        messageNode.style.display = '';
      }
    }
  }

  /**
   * Show 'Customized!' message on first page of documentation if the user is
   * looking at customized doc set
   */
  function showCustomizedNavMessage() {
    if (cookie != null) {
      if (leftnavNode = document.getElementById('toc-customized')) {
        if (adviserPage == '0') {
          leftnavNode.style.display = '';
        }
      }
      if (leftnavNode = document.getElementById('toc-customized-link')) {
        if (adviserPage == 0) {
          leftnavNode.style.display = '';
          leftnavNode.href += 'toc-docset=' + parseInt(cookie, 2);
        }
      }
    } else {
      if (leftnavNode = document.getElementById('toc-uncustomized')) {
        if (adviserPage == '1') {
          leftnavNode.style.display = 'none';
        } else {
          leftnavNode.style.display = '';
        }
      }
    }
  }

  /**
   * Populate the checkboxes in the adviser to show what options the user
   * already selected. This function is useful if the user clicks the 'edit'
   * link in the left nav next to the 'Customized!' text.
   */
  function populateAdviser() {
    var checkboxes = document.getElementsByTagName('input');
    for (var c = 0; c < checkboxes.length; c++) {
      thisCookiePref = cookiePrefs[checkboxes[c].getAttribute('id')];
      if (thisCookiePref) {
        checkboxes[c].checked = true;
      } else if (getParam(checkboxes[c].getAttribute('id')) != null) {
        checkboxes[c].checked = true;
      }
    }
  }

  function initCustomTOC(tocConfig) {

    cookieMap = tocConfig['cookieMap'];
    // Set a string that will be part of the cookie name
    setServiceString(tocConfig['serviceString']);

    // Set the path for the cookie to be the directory where the TOC is located
    var cookiePathMatch = tocConfig['cookiePath'].match(/(.*\/)/);
    setCookiePath(cookiePathMatch[0]);

    // Set the URL prefix for documents in this set.
    setUrlPrefix(tocConfig['urlPrefix']);

    // Create or drop a cookie if necessary, then read any existing cookie.
    setOrDropCookie();

    // Set preferences based on any existing cookie value.
    setCookiePrefs();

    // Get the node name for the page the user is on.
    setDocsetLocation();

    // Build a list of links in the left nav.
    traverseTOC(tocConfig['tocRootNode']);

    // Display appropriate links in the TOC.
    displayTOCLinks();

    // Don't show a parent node if none of its children are shown.
    hideEmptyParents();

    // Show the 'checking video status' doc if 'Uploading videos' is also shown.
    for (var sis in tocConfig['dependencies']) {
      showIfShown(tocConfig['dependencies'][sis][0],
          tocConfig['dependencies'][sis][1]);
    }

    // Exclude links to "Customize this guide" from pagination links
    for (var pe in tocConfig['paginationExcludes']) {
      excludePaginationLink(tocConfig['paginationExcludes'][pe]);
    }

    // Retrieve link text to be used in pagination links.
    getLinkTextFromNavLinks();

    // Override the link text for following nodes:
    for (var to in tocConfig['textOverrides']) {
      overrideLinkText(tocConfig['textOverrides'][to][0],
          tocConfig['textOverrides'][to][1]);
    }

    showCustomizedNavMessage();
  }

  window['customTOC_initCustomTOC'] = initCustomTOC;
  window['customTOC_showCustomizedDocMessage'] = showCustomizedDocMessage;
  window['customTOC_showCustomizedNavMessage'] = showCustomizedNavMessage;
  window['customTOC_writePreviousPageInfo'] = writePreviousPageInfo;
  window['customTOC_writeNextPageInfo'] = writeNextPageInfo;
  window['customTOC_populateAdviser'] = populateAdviser;
  window['customTOC_setOrDropCookie'] = setOrDropCookie;
  window['customTOC_setCookiePath'] = setCookiePath;

})();
