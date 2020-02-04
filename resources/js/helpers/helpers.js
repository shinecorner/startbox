
export default {
    toJson(json, res = {}) {
        if (this.isJson(json)) {
            return json;
        } else if (typeof json == 'string') {
            try {
                return JSON.parse(json);
            } catch (e) {

            }
        }
        return res;
    },

    isJson(json) {
        return typeof json == 'object' && json != null;
    },

    inArray(needle, haystack) {
        for (var i = 0; i < haystack.length; i++) {
            if (haystack[i] == needle) {
                return true;
            }
        }
        return false;
    },

    isPath(needle, haystack) {
        needle = (needle + '').trim().toLowerCase();
        for (var i = 0; i < haystack.length; i++) {
            let patt = new RegExp(haystack[i].trim().toLowerCase(), "g");
            if (patt.test(needle)) {
                return true;
            }
        }
        return false;
    },

    isAssoc(arr) {
        for (var i = 0; i < Object.keys(arr).length; i++) {
            if (typeof arr[i] == 'undefined') {
                return 1;
            }
        }
        return 0;
    },

    capitalize(string) {
        return string.replace(/\w\S*/g, function (txt) { return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase(); });
    },

    blockCard($elem) {
        $($elem).block({
            message: '<div class="ft-refresh-cw icon-spin font-medium-4"></div>',
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.9,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });
    },

    unblockCard($elem, time) {
        time = (time != 'undefined') ? time : 0;
        setTimeout(function () {
            $($elem).unblock()
        }, time);
    },

    blockPage() {
        $('#page-spinner').css('display', 'block');
    },

    unBlockPage(time) {
        time = (time != 'undefined') ? time : 0;
        setTimeout(function () {
            $('#page-spinner').css('display', 'none');
        }, time);
    },

    guidGenerator() {
        var S4 = function () {
            return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
        };
        return (S4() + S4() + S4() + S4() + S4() + Date.now());
    },

    unknownError(error) {
        return {
            'status': 0,
            'errors': [
                'Connection Error!'
            ],
            'data': error
        };
    },

    getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    },

    getValue(obj, key, _default) {
        _default = (typeof _default == 'undefined') ? '' : _default;
        return key.split(".").reduce(function (o, x) {
            return (typeof o[x] == "undefined" || o[x] === null || o[x] == null) ? _default : o[x];
        }, obj);
    },

    has(obj, key) {
        return key.split(".").every(function (x) {
            if (typeof obj != "object" || obj === null || !x in obj)
                return false;
            obj = obj[x];
            return true;
        });
    },

    validateEmail(email) {
        email = email.trim().toLowerCase();
        var emailRegExp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/g;
        var result = emailRegExp.test(email);
        return result;
    },
    validateCVV(cvv) {
        var cvvRegExp = /^[0-9]{3,4}$/g;
        var result = cvvRegExp.test(cvv);
        return result;
    },
    validateExpDate(ExpDate) {
        var ExpdateRegExp = /^(0[1-9]|1[0-2])\/?(([0-9]{4}|[0-9]{2})$)/g;
        var result = ExpdateRegExp.test(ExpDate);
        return result;
    },
    validateExpDateMMYYYY(ExpDate) {
        var ExpdateRegExp = /^((0[1-9])|(1[0-2]))\/(\d{4})$/g;
        var result = ExpdateRegExp.test(ExpDate);
        if (result == true) {
            var dt = new Date();
            var year = ExpDate.split('/')[1];
            if (year >= dt.getFullYear()) {
                return true;
            }
        }
        return false;
    },
    validateCCNumber(ccn) {
        var valid = false;
        ccn.validateCreditCard(function (result) {
            valid = result.valid;
        });
        return valid;
    },

    bytesToSize(bytes) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0) return '0 Byte';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    },

    sizeToBytes(val, unit) {
        var sizes = { 'Bytes': 0, 'KB': 1, 'MB': 2, 'GB': 3, 'TB': 4 };
        return Math.round(val * Math.pow(1024, sizes[unit]), 2);
    },

    setCookie(cname, cvalue, expdays, cpath, cdomain, csecure) {
        var expires = '';
        var szCookieText = escape(cname) + '=' + escape(cvalue);

        if (expdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            expires = "EXPIRES=" + d.toUTCString();
        }

        szCookieText += expires;
        szCookieText += (cpath ? '; PATH=' + cpath : '');
        szCookieText += (cdomain ? '; DOMAIN=' + cdomain : '');
        szCookieText += (csecure ? '; SECURE' : '');

        document.cookie = szCookieText;
    },

    getCookie(cname) {
        var cvalue = 'undefined';
        if (document.cookie)	   //only if exists
        {
            var arr = document.cookie.split((escape(cname) + '='));
            if (2 <= arr.length) {
                var arr2 = arr[1].split(';');
                cvalue = unescape(arr2[0]);
            }
        }
        return cvalue;
    },

    checkCookie(name) {
        return getCookie(name)
    },

    deleteCookie(cname) {
        var tmp = getCookie(cname);
        if (tmp) { setCookie(cname, tmp, (new Date(1))); }
    },
    gotoTop() {
        return $("html, body").animate({ scrollTop: 0 }, "slow");
    },
    numberFormat(number, decimal) {
        decimal = (typeof decimal != 'undefined') ? decimal : 2;
        return (number * 1).toFixed(decimal);
    },
    arrayMove(arr, fromIndex, toIndexl) {
        var element = arr[fromIndex];
        arr.splice(fromIndex, 1);
        arr.splice(toIndexl, 0, element);
    },
    getQueryParameters(){
        var match,
            pl     = /\+/g,  // Regex for replacing addition symbol with a space
            search = /([^&=]+)=?([^&]*)/g,
            decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
            query  = window.location.search.substring(1);

        let urlParams = {};
        while (match = search.exec(query)){
            if(typeof urlParams[decode(match[1])] != 'undefined'){
                if(Array.isArray(urlParams[decode(match[1])])){
                    urlParams[decode(match[1])].push(decode(match[2]));
                }else{
                    urlParams[decode(match[1])] = [urlParams[decode(match[1])], decode(match[2])];
                }
            }else{
                urlParams[decode(match[1])] = decode(match[2]);
            }
        }

        return urlParams;
    },
    getQueryParameter(name, res){
        if (!res) res = '';
        if (!name) return res;

        return this.getValue(this.getQueryParameters(),name,res);
    },

}