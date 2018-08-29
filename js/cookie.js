

var caution = false



function setCookie(name, value, expires, path, domain, secure) {

	var curCookie = name + "=" + escape(value) +

		((expires) ? "; expires=" + expires.toGMTString() : "") +

		((path) ? "; path=" + path : "") +

		((domain) ? "; domain=" + domain : "") +

		((secure) ? "; secure" : "")

	if (!caution || (name + "=" + escape(value)).length <= 4000)

		document.cookie = curCookie

	else

		if (confirm("Cookie превышает 4KB и будет вырезан !"))

			document.cookie = curCookie

}



// name - name of the desired cookie

// * return string containing value of specified cookie or null if cookie does not exist

function getCookie(name) {

	var prefix = name + "="

	var cookieStartIndex = document.cookie.indexOf(prefix)

	if (cookieStartIndex == -1)

		return null

	var cookieEndIndex = document.cookie.indexOf(";", cookieStartIndex + prefix.length)

	if (cookieEndIndex == -1)

		cookieEndIndex = document.cookie.length

	return unescape(document.cookie.substring(cookieStartIndex + prefix.length, cookieEndIndex))

}



// name - name of the cookie

// [path] - path of the cookie (must be same as path used to create cookie)

// [domain] - domain of the cookie (must be same as domain used to create cookie)

// * path and domain default if assigned null or omitted if no explicit argument proceeds

function deleteCookie(name, path, domain) {

	if (getCookie(name)) {

		document.cookie = name + "=" + 

		((path) ? "; path=" + path : "") +

		((domain) ? "; domain=" + domain : "") +

		"; expires=Thu, 01-Jan-70 00:00:01 GMT"

	}

}

