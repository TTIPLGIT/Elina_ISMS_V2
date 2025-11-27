<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ISMS</title>
  <!-- General CSS Files -->
  <link href="{{asset('asset/css/fullcal.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('asset/css/app.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('asset/css/fullcal.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('asset/bundles/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('asset/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />

  <!-- <link href="{{asset('asset/css/font-awesome.min.css')}}" type="text/css" rel="stylesheet" /> -->
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css" rel="stylesheet" />

  <!-- <script src="bs-stepper.min.js"></script> -->
  <!-- <link href="{{asset('asset/css/bs-stepper.css')}}" type="text/css" rel="stylesheet" /> -->

  <!--dropzone css -->
  <!-- jQuery -->
  <script src="{{ asset('asset/js/jquery.min.js') }}"></script>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

  <!-- <link href="{{asset('css/select2.css')}}" type="text/css" rel="stylesheet" /> -->

  <!-- Template CSS -->
  <link href="{{asset('asset/css/style.css')}}" type="text/css" rel="stylesheet" />

  <link href="{{asset('asset/css/components.css')}}" type="text/css" rel="stylesheet" />
  <!-- Custom style CSS -->
  <link href="{{asset('asset/css/custom.css')}}" type="text/css" rel="stylesheet" />

  <link href="{{asset('asset/css/jquery-ui.css')}}" type="text/css" rel="stylesheet" />
  <!-- <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" type="text/css" rel="stylesheet" /> -->

  <link rel="stylesheet" type="text/css" href="{{ asset('css/hummingbird_v1.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/hummingbird_treeview.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.css') }}" />
  <!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/sweet.css') }}"> -->
  <link href="{{asset('asset/css/jquery-ui.css')}}" type="text/css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css">
  <script type="text/javascript" src="{{ asset('js/select2.js') }}"></script>
  <!-- <link href="{{asset('asset/css/sweet-alert.css')}}" type="text/css" rel="stylesheet" /> -->
  <!-- <link rel="stylesheet" href="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css"> -->

  <!-- <script src="{{ asset('asset/js/sweetalert.min.js') }}"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
  <link href="{{asset('asset/css/sweetalert.min.css')}}" type="text/css" rel="stylesheet" />
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css"> -->
  <!-- <script src="{{ asset('asset/js/sweet-alert.min.js') }}"></script> -->
  <script type="text/javascript" src="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.min.js"></script>

  <!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert1.1.3.css') }}"> -->
  <link href="{{asset('asset/css/dropzone.css')}}" type="text/css" rel="stylesheet" />
  <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.css" rel="stylesheet"> -->

  <script type="text/javascript" src="{{ asset('asset/js/dropzone4.js') }}"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.js"></script> -->

  <!-- <script type="text/javascript" src="{{ asset('asset/js/hummingbird_treeview.js') }}"></script> -->
  <!-- <script type="text/javascript" src="{{ asset('js/sweet.js') }}"></script> -->
  <script type="text/javascript" src="{{ asset('asset/js/sweetalert2@11.js') }}"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
  <!-- <script src="bs-stepper.min.js"></script> -->
  <!-- <link href="{{asset('asset/css/bs-stepper.css')}}" type="text/css" rel="stylesheet" /> -->

  <link href="{{asset('assets/css/adminnavbar.min.css')}}" rel="stylesheet" type="text/css" />
  <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script> -->

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <!-- <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&display=swap" rel="stylesheet"> -->
  <link href="{{asset('asset/css/css2.css')}}" type="text/css" rel="stylesheet" />

  <link rel="stylesheet" href="https://unpkg.com/swiper@6.8.1/swiper-bundle.min.css">
  <script disable-devtool-auto="">
        ! function(e, t) {
            "object" == typeof exports && "undefined" != typeof module ? module.exports = t() : "function" == typeof define && define.amd ? define(t) : (e = "undefined" != typeof globalThis ? globalThis : e || self).DisableDevtool = t()
        }(this, function() {
            "use strict";

            function o(e) {
                return (o = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
                    return typeof e
                } : function(e) {
                    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
                })(e)
            }

            function i(e, t) {
                if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
            }

            function r(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var i = t[n];
                    i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i)
                }
            }

            function u(e, t, n) {
                t && r(e.prototype, t), n && r(e, n), Object.defineProperty(e, "prototype", {
                    writable: !1
                })
            }

            function e(e, t, n) {
                t in e ? Object.defineProperty(e, t, {
                    value: n,
                    enumerable: !0,
                    configurable: !0,
                    writable: !0
                }) : e[t] = n
            }

            function n(e, t) {
                if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function");
                e.prototype = Object.create(t && t.prototype, {
                    constructor: {
                        value: e,
                        writable: !0,
                        configurable: !0
                    }
                }), Object.defineProperty(e, "prototype", {
                    writable: !1
                }), t && c(e, t)
            }

            function a(e) {
                return (a = Object.setPrototypeOf ? Object.getPrototypeOf.bind() : function(e) {
                    return e.__proto__ || Object.getPrototypeOf(e)
                })(e)
            }

            function c(e, t) {
                return (c = Object.setPrototypeOf ? Object.setPrototypeOf.bind() : function(e, t) {
                    return e.__proto__ = t, e
                })(e, t)
            }

            function U(e, t) {
                if (t && ("object" == typeof t || "function" == typeof t)) return t;
                if (void 0 !== t) throw new TypeError("Derived constructors may only return object or undefined");
                t = e;
                if (void 0 === t) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                return t
            }

            function l(n) {
                var i = function() {
                    if ("undefined" == typeof Reflect || !Reflect.construct) return !1;
                    if (Reflect.construct.sham) return !1;
                    if ("function" == typeof Proxy) return !0;
                    try {
                        return Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function() {})), !0
                    } catch (e) {
                        return !1
                    }
                }();
                return function() {
                    var e, t = a(n);
                    return U(this, i ? (e = a(this).constructor, Reflect.construct(t, arguments, e)) : t.apply(this, arguments))
                }
            }

            function f(e, t) {
                (null == t || t > e.length) && (t = e.length);
                for (var n = 0, i = new Array(t); n < t; n++) i[n] = e[n];
                return i
            }

            function s(e, t) {
                var n, i = "undefined" != typeof Symbol && e[Symbol.iterator] || e["@@iterator"];
                if (!i) {
                    if (Array.isArray(e) || (i = function(e, t) {
                            if (e) {
                                if ("string" == typeof e) return f(e, t);
                                var n = Object.prototype.toString.call(e).slice(8, -1);
                                return "Map" === (n = "Object" === n && e.constructor ? e.constructor.name : n) || "Set" === n ? Array.from(e) : "Arguments" === n || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n) ? f(e, t) : void 0
                            }
                        }(e)) || t && e && "number" == typeof e.length) return i && (e = i), n = 0, {
                        s: t = function() {},
                        n: function() {
                            return n >= e.length ? {
                                done: !0
                            } : {
                                done: !1,
                                value: e[n++]
                            }
                        },
                        e: function(e) {
                            throw e
                        },
                        f: t
                    };
                    throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")
                }
                var o, r = !0,
                    u = !1;
                return {
                    s: function() {
                        i = i.call(e)
                    },
                    n: function() {
                        var e = i.next();
                        return r = e.done, e
                    },
                    e: function(e) {
                        u = !0, o = e
                    },
                    f: function() {
                        try {
                            r || null == i.return || i.return()
                        } finally {
                            if (u) throw o
                        }
                    }
                }
            }
            var d = !1,
                t = {};

            function v(e) {
                t[e] = !1
            }

            function q() {
                for (var e in t)
                    if (t[e]) return d = !0;
                return d = !1
            }

            function h() {
                return (new Date).getTime()
            }

            function z(e) {
                var t = h();
                return e(), h() - t
            }

            function B(n, i) {
                function e(t) {
                    return function() {
                        n && n();
                        var e = t.apply(void 0, arguments);
                        return i && i(), e
                    }
                }
                var t = window.alert,
                    o = window.confirm,
                    r = window.prompt;
                try {
                    window.alert = e(t), window.confirm = e(o), window.prompt = e(r)
                } catch (e) {}
            }
            var p = {
                iframe: !1,
                pc: !1,
                qqBrowser: !1,
                firefox: !1,
                macos: !1,
                edge: !1,
                oldEdge: !1,
                ie: !1,
                iosChrome: !1,
                iosEdge: !1,
                chrome: !1,
                seoBot: !1,
                mobile: !1
            };

            function W() {
                function e(e) {
                    return -1 !== t.indexOf(e)
                }
                var t = navigator.userAgent.toLowerCase(),
                    n = function() {
                        var e = navigator,
                            t = e.platform,
                            e = e.maxTouchPoints;
                        if ("number" == typeof e) return 1 < e;
                        if ("string" == typeof t) {
                            e = t.toLowerCase();
                            if (/(mac|win)/i.test(e)) return !1;
                            if (/(android|iphone|ipad|ipod|arch)/i.test(e)) return !0
                        }
                        return /(iphone|ipad|ipod|ios|android)/i.test(navigator.userAgent.toLowerCase())
                    }(),
                    i = !!window.top && window !== window.top,
                    o = !n,
                    r = e("qqbrowser"),
                    u = e("firefox"),
                    a = e("macintosh"),
                    c = e("edge"),
                    l = c && !e("chrome"),
                    f = l || e("trident") || e("msie"),
                    s = e("crios"),
                    d = e("edgios"),
                    v = e("chrome") || s,
                    h = !n && /(googlebot|baiduspider|bingbot|applebot|petalbot|yandexbot|bytespider|chrome\-lighthouse|moto g power)/i.test(t);
                Object.assign(p, {
                    iframe: i,
                    pc: o,
                    qqBrowser: r,
                    firefox: u,
                    macos: a,
                    edge: c,
                    oldEdge: l,
                    ie: f,
                    iosChrome: s,
                    iosEdge: d,
                    chrome: v,
                    seoBot: h,
                    mobile: n
                })
            }

            function H() {
                for (var e = function() {
                        for (var e = {}, t = 0; t < 500; t++) e["".concat(t)] = "".concat(t);
                        return e
                    }(), t = [], n = 0; n < 50; n++) t.push(e);
                return t
            }
            var y, K = "",
                V = !1;

            function F() {
                var e = w.ignore;
                if (e) {
                    if ("function" == typeof e) return e();
                    if (0 !== e.length) {
                        var t = location.href;
                        if (K === t) return V;
                        K = t;
                        var n, i = !1,
                            o = s(e);
                        try {
                            for (o.s(); !(n = o.n()).done;) {
                                var r = n.value;
                                if ("string" == typeof r) {
                                    if (-1 !== t.indexOf(r)) {
                                        i = !0;
                                        break
                                    }
                                } else if (r.test(t)) {
                                    i = !0;
                                    break
                                }
                            }
                        } catch (e) {
                            o.e(e)
                        } finally {
                            o.f()
                        }
                        return V = i
                    }
                }
            }(A = y = y || {})[A.Unknown = -1] = "Unknown", A[A.RegToString = 0] = "RegToString", A[A.DefineId = 1] = "DefineId", A[A.Size = 2] = "Size", A[A.DateToString = 3] = "DateToString", A[A.FuncToString = 4] = "FuncToString", A[A.Debugger = 5] = "Debugger", A[A.Performance = 6] = "Performance", A[A.DebugLib = 7] = "DebugLib";
            var b = function() {
                    function n(e) {
                        var t = e.type,
                            e = e.enabled,
                            e = void 0 === e || e;
                        i(this, n), this.type = y.Unknown, this.enabled = !0, this.type = t, this.enabled = e, this.enabled && (t = this, $.push(t), this.init())
                    }
                    return u(n, [{
                        key: "onDevToolOpen",
                        value: function() {
                            var e;
                            console.warn("You don't have permission to use DEVTOOL!【type = ".concat(this.type, "】")), w.clearIntervalWhenDevOpenTrigger && g(), window.clearTimeout(N), w.ondevtoolopen(this.type, J), e = this.type, t[e] = !0
                        }
                    }, {
                        key: "init",
                        value: function() {}
                    }]), n
                }(),
                M = function() {
                    n(t, b);
                    var e = l(t);

                    function t() {
                        return i(this, t), e.call(this, {
                            type: y.DebugLib
                        })
                    }
                    return u(t, [{
                        key: "init",
                        value: function() {}
                    }, {
                        key: "detect",
                        value: function() {
                            var e;
                            (!0 === (null == (e = null == (e = window.eruda) ? void 0 : e._devTools) ? void 0 : e._isShow) || window._vcOrigConsole && window.document.querySelector("#__vconsole.vc-toggle")) && this.onDevToolOpen()
                        }
                    }], [{
                        key: "isUsing",
                        value: function() {
                            return !!window.eruda || !!window._vcOrigConsole
                        }
                    }]), t
                }(),
                X = 0,
                N = 0,
                $ = [],
                G = 0;

            function Y(o) {
                function e() {
                    l = !0
                }

                function t() {
                    l = !1
                }
                var n, i, r, u, a, c, l = !1;

                function f() {
                    (c[u] === r ? i : n)()
                }
                B(e, t), n = t, i = e, void 0 !== (c = document).hidden ? (r = "hidden", a = "visibilitychange", u = "visibilityState") : void 0 !== c.mozHidden ? (r = "mozHidden", a = "mozvisibilitychange", u = "mozVisibilityState") : void 0 !== c.msHidden ? (r = "msHidden", a = "msvisibilitychange", u = "msVisibilityState") : void 0 !== c.webkitHidden && (r = "webkitHidden", a = "webkitvisibilitychange", u = "webkitVisibilityState"), c.removeEventListener(a, f, !1), c.addEventListener(a, f, !1), X = window.setInterval(function() {
                    if (!(o.isSuspend || l || F())) {
                        var e, t, n = s($);
                        try {
                            for (n.s(); !(e = n.n()).done;) {
                                var i = e.value;
                                v(i.type), i.detect(G++)
                            }
                        } catch (e) {
                            n.e(e)
                        } finally {
                            n.f()
                        }
                        D(), "function" == typeof w.ondevtoolclose && (t = d, !q() && t && w.ondevtoolclose())
                    }
                }, w.interval), N = setTimeout(function() {
                    p.pc || M.isUsing() || g()
                }, w.stopIntervalTime)
            }

            function g() {
                window.clearInterval(X)
            }

            function J() {
                if (g(), w.url) window.location.href = w.url;
                else {
                    try {
                        window.opener = null, window.open("", "_self"), window.close(), window.history.back()
                    } catch (e) {
                        console.log(e)
                    }
                    setTimeout(function() {
                        window.location.href = w.timeOutUrl || "https://theajack.github.io/disable-devtool/404.html?h=".concat(encodeURIComponent(location.host))
                    }, 500)
                }
            }
            var w = {
                    md5: "",
                    ondevtoolopen: J,
                    ondevtoolclose: null,
                    url: "",
                    timeOutUrl: "",
                    tkName: "ddtk",
                    interval: 500,
                    disableMenu: !0,
                    stopIntervalTime: 5e3,
                    clearIntervalWhenDevOpenTrigger: !1,
                    detectors: [0, 1, 3, 4, 5, 6, 7],
                    clearLog: !0,
                    disableSelect: !1,
                    disableCopy: !1,
                    disableCut: !1,
                    disablePaste: !1,
                    ignore: null,
                    disableIframeParents: !0,
                    seo: !0
                },
                Q = ["detectors", "ondevtoolclose", "ignore"];

            function Z(e) {
                var t, n = 0 < arguments.length && void 0 !== e ? e : {};
                for (t in w) {
                    var i = t;
                    void 0 === n[i] || o(w[i]) !== o(n[i]) && -1 === Q.indexOf(i) || (w[i] = n[i])
                }
                "function" == typeof w.ondevtoolclose && !0 === w.clearIntervalWhenDevOpenTrigger && (w.clearIntervalWhenDevOpenTrigger = !1, console.warn("【DISABLE-DEVTOOL】clearIntervalWhenDevOpenTrigger 在使用 ondevtoolclose 时无效"))
            }
            var m, T, ee, O = window.console || {
                log: function() {},
                table: function() {},
                clear: function() {}
            };

            function D() {
                w.clearLog && ee()
            }
            var te = function() {
                return !1
            };

            function S(n) {
                var e, i = 74,
                    o = 73,
                    r = 85,
                    u = 83,
                    a = 123,
                    c = p.macos ? function(e, t) {
                        return e.metaKey && e.altKey && (t === o || t === i)
                    } : function(e, t) {
                        return e.ctrlKey && e.shiftKey && (t === o || t === i)
                    },
                    l = p.macos ? function(e, t) {
                        return e.metaKey && e.altKey && t === r || e.metaKey && t === u
                    } : function(e, t) {
                        return e.ctrlKey && (t === u || t === r)
                    };
                n.addEventListener("keydown", function(e) {
                    var t = (e = e || n.event).keyCode || e.which;
                    if (t === a || c(e, t) || l(e, t)) return ne(n, e)
                }, !0), e = n, w.disableMenu && k(e, "contextmenu"), e = n, w.disableSelect && k(e, "selectstart"), e = n, w.disableCopy && k(e, "copy"), e = n, w.disableCut && k(e, "cut"), e = n, w.disablePaste && k(e, "paste")
            }

            function k(t, e) {
                t.addEventListener(e, function(e) {
                    return ne(t, e)
                })
            }

            function ne(e, t) {
                if (!F() && !te()) return (t = t || e.event).returnValue = !1, t.preventDefault(), !1
            }
            var P = 8;

            function ie(e) {
                for (var t = function(e, t) {
                        e[t >> 5] |= 128 << t % 32, e[14 + (t + 64 >>> 9 << 4)] = t;
                        for (var n = 1732584193, i = -271733879, o = -1732584194, r = 271733878, u = 0; u < e.length; u += 16) {
                            var a = n,
                                c = i,
                                l = o,
                                f = r;
                            n = j(n, i, o, r, e[u + 0], 7, -680876936), r = j(r, n, i, o, e[u + 1], 12, -389564586), o = j(o, r, n, i, e[u + 2], 17, 606105819), i = j(i, o, r, n, e[u + 3], 22, -1044525330), n = j(n, i, o, r, e[u + 4], 7, -176418897), r = j(r, n, i, o, e[u + 5], 12, 1200080426), o = j(o, r, n, i, e[u + 6], 17, -1473231341), i = j(i, o, r, n, e[u + 7], 22, -45705983), n = j(n, i, o, r, e[u + 8], 7, 1770035416), r = j(r, n, i, o, e[u + 9], 12, -1958414417), o = j(o, r, n, i, e[u + 10], 17, -42063), i = j(i, o, r, n, e[u + 11], 22, -1990404162), n = j(n, i, o, r, e[u + 12], 7, 1804603682), r = j(r, n, i, o, e[u + 13], 12, -40341101), o = j(o, r, n, i, e[u + 14], 17, -1502002290), i = j(i, o, r, n, e[u + 15], 22, 1236535329), n = I(n, i, o, r, e[u + 1], 5, -165796510), r = I(r, n, i, o, e[u + 6], 9, -1069501632), o = I(o, r, n, i, e[u + 11], 14, 643717713), i = I(i, o, r, n, e[u + 0], 20, -373897302), n = I(n, i, o, r, e[u + 5], 5, -701558691), r = I(r, n, i, o, e[u + 10], 9, 38016083), o = I(o, r, n, i, e[u + 15], 14, -660478335), i = I(i, o, r, n, e[u + 4], 20, -405537848), n = I(n, i, o, r, e[u + 9], 5, 568446438), r = I(r, n, i, o, e[u + 14], 9, -1019803690), o = I(o, r, n, i, e[u + 3], 14, -187363961), i = I(i, o, r, n, e[u + 8], 20, 1163531501), n = I(n, i, o, r, e[u + 13], 5, -1444681467), r = I(r, n, i, o, e[u + 2], 9, -51403784), o = I(o, r, n, i, e[u + 7], 14, 1735328473), i = I(i, o, r, n, e[u + 12], 20, -1926607734), n = E(n, i, o, r, e[u + 5], 4, -378558), r = E(r, n, i, o, e[u + 8], 11, -2022574463), o = E(o, r, n, i, e[u + 11], 16, 1839030562), i = E(i, o, r, n, e[u + 14], 23, -35309556), n = E(n, i, o, r, e[u + 1], 4, -1530992060), r = E(r, n, i, o, e[u + 4], 11, 1272893353), o = E(o, r, n, i, e[u + 7], 16, -155497632), i = E(i, o, r, n, e[u + 10], 23, -1094730640), n = E(n, i, o, r, e[u + 13], 4, 681279174), r = E(r, n, i, o, e[u + 0], 11, -358537222), o = E(o, r, n, i, e[u + 3], 16, -722521979), i = E(i, o, r, n, e[u + 6], 23, 76029189), n = E(n, i, o, r, e[u + 9], 4, -640364487), r = E(r, n, i, o, e[u + 12], 11, -421815835), o = E(o, r, n, i, e[u + 15], 16, 530742520), i = E(i, o, r, n, e[u + 2], 23, -995338651), n = C(n, i, o, r, e[u + 0], 6, -198630844), r = C(r, n, i, o, e[u + 7], 10, 1126891415), o = C(o, r, n, i, e[u + 14], 15, -1416354905), i = C(i, o, r, n, e[u + 5], 21, -57434055), n = C(n, i, o, r, e[u + 12], 6, 1700485571), r = C(r, n, i, o, e[u + 3], 10, -1894986606), o = C(o, r, n, i, e[u + 10], 15, -1051523), i = C(i, o, r, n, e[u + 1], 21, -2054922799), n = C(n, i, o, r, e[u + 8], 6, 1873313359), r = C(r, n, i, o, e[u + 15], 10, -30611744), o = C(o, r, n, i, e[u + 6], 15, -1560198380), i = C(i, o, r, n, e[u + 13], 21, 1309151649), n = C(n, i, o, r, e[u + 4], 6, -145523070), r = C(r, n, i, o, e[u + 11], 10, -1120210379), o = C(o, r, n, i, e[u + 2], 15, 718787259), i = C(i, o, r, n, e[u + 9], 21, -343485551), n = _(n, a), i = _(i, c), o = _(o, l), r = _(r, f)
                        }
                        return Array(n, i, o, r)
                    }(function(e) {
                        for (var t = Array(), n = (1 << P) - 1, i = 0; i < e.length * P; i += P) t[i >> 5] |= (e.charCodeAt(i / P) & n) << i % 32;
                        return t
                    }(e), e.length * P), n = "0123456789abcdef", i = "", o = 0; o < 4 * t.length; o++) i += n.charAt(t[o >> 2] >> o % 4 * 8 + 4 & 15) + n.charAt(t[o >> 2] >> o % 4 * 8 & 15);
                return i
            }

            function x(e, t, n, i, o, r) {
                return _((t = _(_(t, e), _(i, r))) << o | t >>> 32 - o, n)
            }

            function j(e, t, n, i, o, r, u) {
                return x(t & n | ~t & i, e, t, o, r, u)
            }

            function I(e, t, n, i, o, r, u) {
                return x(t & i | n & ~i, e, t, o, r, u)
            }

            function E(e, t, n, i, o, r, u) {
                return x(t ^ n ^ i, e, t, o, r, u)
            }

            function C(e, t, n, i, o, r, u) {
                return x(n ^ (t | ~i), e, t, o, r, u)
            }

            function _(e, t) {
                var n = (65535 & e) + (65535 & t);
                return (e >> 16) + (t >> 16) + (n >> 16) << 16 | 65535 & n
            }
            var A = function() {
                    n(t, b);
                    var e = l(t);

                    function t() {
                        return i(this, t), e.call(this, {
                            type: y.RegToString,
                            enabled: p.qqBrowser || p.firefox
                        })
                    }
                    return u(t, [{
                        key: "init",
                        value: function() {
                            var t = this;
                            this.lastTime = 0, this.reg = /./, m(this.reg), this.reg.toString = function() {
                                var e;
                                return p.qqBrowser ? (e = (new Date).getTime(), t.lastTime && e - t.lastTime < 100 ? t.onDevToolOpen() : t.lastTime = e) : p.firefox && t.onDevToolOpen(), ""
                            }
                        }
                    }, {
                        key: "detect",
                        value: function() {
                            m(this.reg)
                        }
                    }]), t
                }(),
                oe = function() {
                    n(t, b);
                    var e = l(t);

                    function t() {
                        return i(this, t), e.call(this, {
                            type: y.DefineId
                        })
                    }
                    return u(t, [{
                        key: "init",
                        value: function() {
                            var e = this;
                            this.div = document.createElement("div"), this.div.__defineGetter__("id", function() {
                                e.onDevToolOpen()
                            }), Object.defineProperty(this.div, "id", {
                                get: function() {
                                    e.onDevToolOpen()
                                }
                            })
                        }
                    }, {
                        key: "detect",
                        value: function() {
                            m(this.div)
                        }
                    }]), t
                }(),
                re = function() {
                    n(t, b);
                    var e = l(t);

                    function t() {
                        return i(this, t), e.call(this, {
                            type: y.Size,
                            enabled: !p.iframe && !p.edge
                        })
                    }
                    return u(t, [{
                        key: "init",
                        value: function() {
                            var e = this;
                            this.checkWindowSizeUneven(), window.addEventListener("resize", function() {
                                setTimeout(function() {
                                    e.checkWindowSizeUneven()
                                }, 100)
                            }, !0)
                        }
                    }, {
                        key: "detect",
                        value: function() {}
                    }, {
                        key: "checkWindowSizeUneven",
                        value: function() {
                            var e = function() {
                                if (ue(window.devicePixelRatio)) return window.devicePixelRatio;
                                var e = window.screen;
                                return !(ue(e) || !e.deviceXDPI || !e.logicalXDPI) && e.deviceXDPI / e.logicalXDPI
                            }();
                            if (!1 !== e) {
                                var t = 200 < window.outerWidth - window.innerWidth * e,
                                    e = 300 < window.outerHeight - window.innerHeight * e;
                                if (t || e) return this.onDevToolOpen(), !1;
                                v(this.type)
                            }
                            return !0
                        }
                    }]), t
                }();

            function ue(e) {
                return null != e
            }
            var L, ae = function() {
                    n(t, b);
                    var e = l(t);

                    function t() {
                        return i(this, t), e.call(this, {
                            type: y.DateToString,
                            enabled: !p.iosChrome && !p.iosEdge
                        })
                    }
                    return u(t, [{
                        key: "init",
                        value: function() {
                            var e = this;
                            this.count = 0, this.date = new Date, this.date.toString = function() {
                                return e.count++, ""
                            }
                        }
                    }, {
                        key: "detect",
                        value: function() {
                            this.count = 0, m(this.date), D(), 2 <= this.count && this.onDevToolOpen()
                        }
                    }]), t
                }(),
                ce = function() {
                    n(t, b);
                    var e = l(t);

                    function t() {
                        return i(this, t), e.call(this, {
                            type: y.FuncToString,
                            enabled: !p.iosChrome && !p.iosEdge
                        })
                    }
                    return u(t, [{
                        key: "init",
                        value: function() {
                            var e = this;
                            this.count = 0, this.func = function() {}, this.func.toString = function() {
                                return e.count++, ""
                            }
                        }
                    }, {
                        key: "detect",
                        value: function() {
                            this.count = 0, m(this.func), D(), 2 <= this.count && this.onDevToolOpen()
                        }
                    }]), t
                }(),
                le = function() {
                    n(t, b);
                    var e = l(t);

                    function t() {
                        return i(this, t), e.call(this, {
                            type: y.Debugger,
                            enabled: p.iosChrome || p.iosEdge
                        })
                    }
                    return u(t, [{
                        key: "detect",
                        value: function() {
                            var e = h();
                            100 < h() - e && this.onDevToolOpen()
                        }
                    }]), t
                }(),
                fe = function() {
                    n(t, b);
                    var e = l(t);

                    function t() {
                        return i(this, t), e.call(this, {
                            type: y.Performance,
                            enabled: p.chrome || !p.mobile
                        })
                    }
                    return u(t, [{
                        key: "init",
                        value: function() {
                            this.maxPrintTime = 0, this.largeObjectArray = H()
                        }
                    }, {
                        key: "detect",
                        value: function() {
                            var e = this,
                                t = z(function() {
                                    T(e.largeObjectArray)
                                }),
                                n = z(function() {
                                    m(e.largeObjectArray)
                                });
                            if (this.maxPrintTime = Math.max(this.maxPrintTime, n), D(), 0 === t || 0 === this.maxPrintTime) return !1;
                            t > 10 * this.maxPrintTime && this.onDevToolOpen()
                        }
                    }]), t
                }(),
                se = (e(L = {}, y.RegToString, A), e(L, y.DefineId, oe), e(L, y.Size, re), e(L, y.DateToString, ae), e(L, y.FuncToString, ce), e(L, y.Debugger, le), e(L, y.Performance, fe), e(L, y.DebugLib, M), L);
            var R = Object.assign(function(e) {
                function t() {
                    var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : "";
                    return {
                        success: !e,
                        reason: e
                    }
                }
                if (R.isRunning) return t("already running");
                if (W(), ee = p.ie ? (m = function() {
                        return O.log.apply(O, arguments)
                    }, T = function() {
                        return O.table.apply(O, arguments)
                    }, function() {
                        return O.clear()
                    }) : (m = O.log, T = O.table, O.clear), Z(e), w.md5 && ie(function(e) {
                        var t = window.location.search,
                            n = window.location.hash;
                        if ("" !== (t = "" === t && "" !== n ? "?".concat(n.split("?")[1]) : t) && void 0 !== t) {
                            n = new RegExp("(^|&)" + e + "=([^&]*)(&|$)", "i"), e = t.substr(1).match(n);
                            if (null != e) return unescape(e[2])
                        }
                        return ""
                    }(w.tkName)) === w.md5) return t("token passed");
                if (w.seo && p.seoBot) return t("seobot");
                R.isRunning = !0, Y(R);
                var n = R,
                    i = (te = function() {
                        return n.isSuspend
                    }, window.top),
                    o = window.parent;
                if (S(window), w.disableIframeParents && i && o && i !== window) {
                    for (; o !== i;) S(o), o = o.parent;
                    S(i)
                }
                return ("all" === w.detectors ? Object.keys(se) : w.detectors).forEach(function(e) {
                    new se[e]
                }), t()
            }, {
                isRunning: !1,
                isSuspend: !1,
                md5: ie,
                version: "0.3.6",
                DetectorType: y,
                isDevToolOpened: q
            });
            A = function() {
                if ("undefined" == typeof window || !window.document) return null;
                var n = document.querySelector("[disable-devtool-auto]");
                if (!n) return null;
                var i = ["disable-menu", "disable-select", "disable-copy", "disable-cut", "disable-paste", "clear-log"],
                    o = ["interval"],
                    r = {};
                return ["md5", "url", "tk-name", "detectors"].concat(i, o).forEach(function(e) {
                    var t = n.getAttribute(e);
                    null !== t && (-1 !== o.indexOf(e) ? t = parseInt(t) : -1 !== i.indexOf(e) ? t = "false" !== t : "detector" === e && "all" !== t && (t = t.split(" ")), r[function(e) {
                        if (-1 === e.indexOf("-")) return e;
                        var t = !1;
                        return e.split("").map(function(e) {
                            return "-" === e ? (t = !0, "") : t ? (t = !1, e.toUpperCase()) : e
                        }).join("")
                    }(e)] = t)
                }), r
            }();
            return A && R(A), R
        });
    </script>
  <style>
    .li {
      padding-top: 10px;
    }

    .nav11 {
      background-color: #398eb1 !important;
      font-family: sans-serif;
      box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, .15) !important;
    }

    .navheading {
      color: #f2f2f2;
    }
  </style>
  <style>
    .fs-7 {
      font-size: 0.8rem !important;
    }

    .fs-8 {
      font-size: 0.6rem !important;
    }

    .p-01 {
      padding: 0.1rem !important;
    }

    .border-0d6efd63 {
      border-color: #0d6efd63 !important;
    }

    /* .border-00ffff{
            border-color: #00ffff !important;
        } */
    .card-height {
      height: 20rem !important;
    }

    .card-body-height {
      height: 10rem !important;
    }

    .card-header-height {
      height: 13rem !important;
    }

    .bg-fff5cc {
      background-color: #a190f0 !important;
    }

    .bg-99ffbb {
      background-color: #8974ec !important;
    }

    .bg-ccffff {
      background-color: #eaf5f3 !important;
    }

    .text-d8c4c4 {
      color: #d8c4c4 !important;
    }

    .text-f2bf26 {
      color: black !important;
    }

    .text-b34700 {
      color: #da6969 !important;
    }

    .text-fae333 {
      color: #fae333 !important;
      font-weight: 600 !important;
    }

    .bg-fae333 {
      background-color: #fcee85 !important;
    }

    .bg-ffcccc {
      background-color: #ffcccc !important;
    }

    .bg-smokewhite {
      background-color: white !important;
    }

    .scroll {
      -ms-overflow-style: none;
      scrollbar-width: none;
      height: 200px;
      display: flex;
      flex-direction: column;
      overflow-y: scroll;
    }




    .flow-width {
      width: 4.5rem !important;
    }

    @media (min-width:374.96px) {
      .flow-width {
        width: 2.5rem !important;
      }
    }

    @media (min-width:424.96px) {
      .flow-width {
        width: 2.5rem !important;
      }
    }

    @media (min-width:575.96px) {
      .flow-width {
        width: 2.5rem !important;
      }
    }

    @media (min-width:767.96px) {
      .flow-width {
        width: 2.5rem !important;
      }
    }

    @media (min-width:991.96px) {
      .col-lg-2-5 {
        flex: 0 0 auto;
        width: 20.5%;
      }

      .flow-width {
        width: 3.5rem !important;
      }
    }

    @media (min-width:1199.96px) {
      .flow-width {
        width: 4.5rem !important;
      }
    }
  </style>
  <style>
    .fs-7 {
      font-size: 0.8rem !important;
    }

    .fs-8 {
      font-size: 0.6rem !important;
    }

    .p-01 {
      padding: 0.1rem !important;
    }

    .border-0d6efd63 {
      border-color: #0d6efd63 !important;
    }

    /* .border-00ffff{
            border-color: #00ffff !important;
        } */
    .card-height {
      height: 20rem !important;
    }

    .card-body-height {
      height: 10rem !important;
    }

    .card-header-height {
      height: 13rem !important;
    }

    .bg-fff5cc {
      background-color: #a190f0 !important;
    }

    .bg-99ffbb {
      background-color: #8974ec !important;
    }

    .bg-ccffff {
      background-color: #eaf5f3 !important;
    }

    .text-d8c4c4 {
      color: #d8c4c4 !important;
    }

    .text-f2bf26 {
      color: black !important;
    }

    .text-b34700 {
      color: #da6969 !important;
    }

    .text-fae333 {
      color: #fae333 !important;
      font-weight: 600 !important;
    }

    .bg-fae333 {
      background-color: #fcee85 !important;
    }

    .bg-ffcccc {
      background-color: #ffcccc !important;
    }

    .bg-smokewhite {
      background-color: white !important;
    }

    .scroll {
      -ms-overflow-style: none;
      scrollbar-width: none;
      height: 200px;
      display: flex;
      flex-direction: column;
      overflow-y: scroll;
    }

    .flow-width {
      width: 4.5rem !important;
    }

    @media (min-width:374.96px) {
      .flow-width {
        width: 2.5rem !important;
      }
    }

    @media (min-width:424.96px) {
      .flow-width {
        width: 2.5rem !important;
      }
    }

    @media (min-width:575.96px) {
      .flow-width {
        width: 2.5rem !important;
      }
    }

    @media (min-width:767.96px) {
      .flow-width {
        width: 2.5rem !important;
      }
    }

    @media (min-width:991.96px) {
      .col-lg-2-5 {
        flex: 0 0 auto;
        width: 20.5%;
      }

      .flow-width {
        width: 3.5rem !important;
      }
    }

    @media (min-width:1199.96px) {
      .flow-width {
        width: 4.5rem !important;
      }
    }

    .buttonedu {
      display: flex !important;
      justify-content: space-around !important;
      padding: 10px;
    }

    .back-btn {
      background: red !important;
      border-color: red !important;
    }
  </style>

  <style>
    .navigation {
      /*position: fixed;*/
      top: 0;
      /*  width: 100%;
  height: 60px;
  background: #3f9cb5;*/
    }

    .navigation .inner-navigation {
      padding: 0;
      margin: 0;
    }

    .navigation .inner-navigation li {
      list-style-type: none;
    }

    .navigation .inner-navigation li .menu-link {
      color: #085a7e;
      line-height: 3.7em;
      padding: 20px 18px;
      text-decoration: none;
      transition: background 0.5s, color 0.5s;
    }

    .navigation .inner-navigation li .menu-link.menu-anchor {
      padding: 20px;
      margin: 0;
      background: #bea20f;
      color: #FFF;
    }

    .navigation .inner-navigation li .menu-link.has-notifications {
      background: #085a7e;
      color: #FFF;
    }

    .navigation .inner-navigation li .menu-link.circle {
      line-height: 3.8rem;
      padding: 14px 18px !important;
      border-radius: 50%;
    }

    .navigation .inner-navigation li .menu-link.circle:hover {
      background: #085a7e;
      color: #FFF;
    }

    .navigation .inner-navigation li .menu-link.square:hover {
      background: #085a7e;
      color: #FFF;
      transition: background 0.5s, color 0.5s;
    }

    .dropdown-container {
      overflow-y: hidden;
    }

    .dropdown-container.expanded .dropdown {
      -webkit-animation: fadein 0.5s;
      -moz-animation: fadein 0.5s;
      -ms-animation: fadein 0.5s;
      -o-animation: fadein 0.5s;
      animation: fadein 0.5s;
      display: block;
    }

    .dropdown-container .dropdown {
      -webkit-animation: fadeout 0.5s;
      -moz-animation: fadeout 0.5s;
      -ms-animation: fadeout 0.5s;
      -o-animation: fadeout 0.5s;
      animation: fadeout 0.5s;
      display: none;
      position: absolute;
      width: 300px;
      height: auto;
      max-height: 600px;
      overflow-y: hidden;
      padding: 0;
      margin: 0;
      background: #eee;
      margin-top: 3px;
      margin-right: -15px;
      border-top: 4px solid #085a7e;
      border-bottom-left-radius: 15px;
      border-bottom-right-radius: 15px;
      -webkit-box-shadow: 2px 2px 15px -5px rgba(0, 0, 0, 0.75);
      -moz-box-shadow: 2px 2px 15px -5px rgba(0, 0, 0, 0.75);
      box-shadow: 2px 2px 15px -5px rgba(0, 0, 0, 0.75);
      /*
  &:before{
    position: absolute;
    content: ' ';
    width: 0; 
    height: 0; 
    top: -13px;
    right: 7px;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    border-bottom: 10px solid $secondary-color; 
  }
  */
    }

    .dropdown-container .dropdown .notification-group {
      border-bottom: 1px solid #e3e3e3;
      overflow: hidden;
      min-height: 65px;
    }

    .dropdown-container .dropdown .notification-group:last-child {
      border-bottom: 0;
      border-bottom-left-radius: 15px;
      border-bottom-right-radius: 15px;
    }

    .dropdown-container .dropdown .notification-group .notification-tab {
      padding: 0px 25px;
      min-height: 65px;
    }

    .dropdown-container .dropdown .notification-group .notification-tab:hover {
      cursor: pointer;
      background: #3f9cb5;
    }

    .dropdown-container .dropdown .notification-group .notification-tab:hover .fa,
    .dropdown-container .dropdown .notification-group .notification-tab:hover h4,
    .dropdown-container .dropdown .notification-group .notification-tab:hover .label {
      color: #FFF;
      display: inline-block;
    }

    .dropdown-container .dropdown .notification-group .notification-tab:hover .label {
      background: #085a7e;
      border-color: #085a7e;
    }

    .dropdown-container .dropdown .notification-group .notification-list {
      padding: 0;
      overflow-y: auto;
      height: 0px;
      max-height: 250px;
      transition: height 0.5s;
    }

    .dropdown-container .dropdown .notification-group .notification-list .notification-list-item {
      padding: 5px 25px;
      border-bottom: 1px solid #e3e3e3;
    }

    .dropdown-container .dropdown .notification-group .notification-list .notification-list-item .message {
      margin: 5px 5px 10px;
    }

    .dropdown-container .dropdown .notification-group .notification-list .notification-list-item .item-footer a {
      color: #3f9cb5;
      text-decoration: none;
    }

    .dropdown-container .dropdown .notification-group .notification-list .notification-list-item .item-footer .date {
      float: right;
    }

    .dropdown-container .dropdown .notification-group .notification-list .notification-list-item:nth-of-type(odd) {
      background: #e3e3e3;
    }

    .dropdown-container .dropdown .notification-group .notification-list .notification-list-item:hover {
      cursor: pointer;
    }

    .dropdown-container .dropdown .notification-group .notification-list .notification-list-item:last-child {
      border-bottom: 0;
      border-bottom-left-radius: 15px;
      border-bottom-right-radius: 15px;
    }

    .dropdown-container .dropdown .notification-group.expanded .notification-tab {
      background: #3f9cb5;
    }

    .dropdown-container .dropdown .notification-group.expanded .notification-tab .fa,
    .dropdown-container .dropdown .notification-group.expanded .notification-tab h4,
    .dropdown-container .dropdown .notification-group.expanded .notification-tab .label {
      color: #FFF;
      display: inline-block;
    }

    .dropdown-container .dropdown .notification-group.expanded .notification-tab .label {
      background: #085a7e;
      border-color: #085a7e;
    }

    .dropdown-container .dropdown .notification-group.expanded .notification-list {
      height: 150px;
      max-height: 250px;
      transition: height 0.5s;
    }

    .dropdown-container .dropdown .notification-group .fa,
    .dropdown-container .dropdown .notification-group h4,
    .dropdown-container .dropdown .notification-group .label {
      color: #333;
      display: inline-block;
    }

    .dropdown-container .dropdown .notification-group .fa {
      margin-right: 5px;
      margin-top: 25px;
    }

    .dropdown-container .dropdown .notification-group .label {
      float: right;
      margin-top: 20px;
      color: #3f9cb5;
      border: 1px solid #3f9cb5;
      padding: 0px 7px;
      border-radius: 15px;
    }

    .tile-body-height {
      height: 60vh;
      overflow-y: overlay;
      padding-right: 25px;
    }

    .right {
      float: right;
    }

    .left {
      float: left;
      list-style: none;
    }

    .badge {
      line-height: 20px !important;
      /* margin: auto; */
      /* align-items: flex-end; */
      /* margin: auto; */
      position: absolute !important;
      /* margin-top: 2rem; */
      top: 6px !important;
      right: 60px !important;
      /* padding: 1rem; */
      border-radius: 50px !important;
      width: 20px !important;
      height: 20px !important;
      background-color: red !important;
      color: white !important;
      font-size: 8px !important;
      padding: 1px 4px !important;
    }

    .table:not(.table-sm) thead th {
      background-color: rgb(9 48 110) !important;
    }

    .loader {
      position: fixed;
      left: 0px;
      top: 0px;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background: url('/images/loader.gif') 50% 50% no-repeat rgb(249, 249, 249);
    }

    .required:after {
      content: " *";
      color: red;
    }

    .dropdown {
      position: relative;
    }

    .dropdown-content {
      position: absolute;
      top: 0;
      right: 10px;
    }

    .alert-head-background {
      background-color: rgb(39 86 104);
      color: #fff;
    }

    .alert-row-top {
      margin-top: 75px
    }

    .alert-message-top {
      margin-top: 20px;
    }

    .alert-image-size {
      width: 75px;
    }

    .btn-alert {
      background-color: rgb(39 86 104) !important;
      color: #fff !important;
    }

    .sweet-alert button {
      background-color: #000dff !important;
    }

    li.dropdown {
      cursor: pointer;
    }

    .readonly {
      background-color: #8080803d !important;
    }

    .form-control:disabled,
    .form-control[readonly] {
      background-color: #e9ecef !important;
      opacity: 1;
    }
  </style>

</head>

<body>
  <div id="app">
    <div class='loader'></div>

    <div id="app">
      <div class="main-wrapper main-wrapper-1">
        <nav class="navbar nav11 navbar-expand-lg main-navbar" style="left: 0;">
          <div class="form-inline mr-auto">
            <ul class="navbar-nav mr-3">
              <li>
                <a href="#" class="nav-link nav-link-lg fullscreen-btn">
                  <i class="fas fa-expand navheading"></i>
                </a>
              </li>
            </ul>

          </div>
          <div class="form-inline mr-auto d-md-inline-block d-none" style="color: #2a0245!important; font-weight: 900; font-size: 28px">

            <span style="  color:white; padding: 10px;" class="nav_heading"><b class="navheading">ELINA ISMS PORTAL</b>
              <span style="color: #9958ae; right: -90px;position: relative;" class="user_name_nav"></span></span>


          </div>


          <ul class="navbar-nav navbar-right" style="width: 160px;">
            <nav class="navigation" style="width: 20%;margin-right: 10px !important;">

              <span class="badge badge-light badgeworkflow" style="right: 130px !important;"></span>

              <ul class="inner-navigation">

                <li class="left">
                  <!--span class="notification-label"></span-->

                  <div class="dropdown-container">
                    <a href="#" data-dropdown="notificationMenu" class="menu-link has-notifications circle">
                      <i class="fa fa-bell"></i><span class="badge badge-light"></span>
                    </a>
                    <ul class="dropdown" name="notificationMenu">

                </li>
                @if($modules['user_role'] != 'Parent')
                <li class="notification-group">
                  <div class="notification-tab">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <h4 style="font-size:15px" class="">Users</h4>
                    <span class="user_name_alert1"></span>
                  </div>
                  <!-- tab -->
                  <ul class="notification-list user_alert_list">








                  </ul>
                </li>
                @endif
                <li class="notification-group">
                  <div class="notification-tab">
                    <i class="fa fa-users" aria-hidden="true"></i>
                    <h4 style="font-size:15px" class="">Enrollment</h4>
                    <span class="user_name_alert2"></span>
                  </div>
                  <!-- tab -->
                  <ul class="notification-list form_alert_list">






                  </ul>
                </li>

                <li class="notification-group">
                  <div class="notification-tab">
                    <i class="fa fa-money" aria-hidden="true"></i>
                    <h4 style="font-size:15px" class="">Payment</h4>
                    <span class="user_name_alert3"></span>
                  </div>

                  <ul class="notification-list payment_alert_list">





                  </ul>
                </li>

                <li class="notification-group">
                  <div class="notification-tab">
                    <i class="fa fa-flag goldenrod"></i>
                    <h4 style="font-size:15px" class="">OVM Meeting</h4>
                    <span class="user_name_alert6"></span>
                  </div>

                  <ul class="notification-list ovm_meeting">






                  </ul>
                </li>


                <li class="notification-group">
                  <div class="notification-tab">
                    <i class="fa fa-flag goldenrod"></i>
                    <h4 style="font-size:15px" class="">Questionnaire</h4>
                    <span class="questionnaire_alert_list"></span>
                  </div>
                  <ul class="notification-list questionnaire_alert_list1">
                  </ul>
                </li>

                <li class="notification-group">
                  <div class="notification-tab">
                    <i class="fa fa-flag goldenrod"></i>
                    <h4 style="font-size:15px" class="">SAIL</h4>
                    <span class="activity_alert_list1"></span>
                  </div>
                  <ul class="notification-list activity_alert_list">
                  </ul>
                </li>

                <!-- <li class="notification-group">
          <div class="notification-tab">
            <i class="fa fa-flag goldenrod"></i>
            <h4 style="font-size:15px" class="">Home Tracker</h4>
            <span class="questionnaire_alert_list"></span>
          </div>         
          <ul class="notification-list questionnaire_alert_list1">
          </ul>
        </li>  -->

              </ul>
      </div>
      </li>
      </ul>

      </nav>


      <li class="dropdown" style="width: 80%;">
        <a data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user d-flex align-items-center">
          <i class="fas fa-user navheading"></i>
          <span class="d-sm-none d-lg-inline-block" style="margin: 0 0 0 10px;"></span>{{$modules['user_role']}}</a>
        <div class="dropdown-menu dropdown-menu-right">

          <!-- <a href="{{ url('admin_profile') }}" class="dropdown-item has-icon">
                <i class="far fa-user" style="color:red !important;"></i><b style="color:blue !important;">Profile</b></a> -->
          <a class="dropdown-item has-icon" href="{{ route('profilepage') }}"><i class="fa fa-user" style="color:red !important;"></i><b style="color:blue !important;">Profile</b></a>
          <a class="dropdown-item has-icon" href="{{ route('main_index') }}"><i class="fa fa-question-circle" style="color:red !important;"></i><b style="color:blue !important;">FAQ</b></a>

          <a href="{{ route('logout') }}" class="dropdown-item has-icon" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out" style="color:red !important;"></i><b style="color:blue !important;">Logout</b></a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf

          </form>
        </div>
      </li>


      </ul>
      </nav>


    </div>
  </div>

  <main class="py-4">



    @yield('content')
  </main>

  <!-- <script type="text/javascript">$('#listDataTable').DataTable();</script> -->

  <script type="text/javascript">
 $(window).on('load', function() {
  $(".loader").fadeOut("slow");
})
</script>

<script type="text/javascript">
      //Open dropdown when clicking on element
      $(document).on('click', "a[data-dropdown='notificationMenu']",  function(e){
        e.preventDefault();
        
        var el = $(e.currentTarget);
        
        $('body').prepend('<div id="dropdownOverlay" style="background: transparent; height:100%;width:100%;position:fixed;"></div>')
        
        var container = $(e.currentTarget).parent();
        var dropdown = container.find('.dropdown');
        var containerWidth = container.width();
        var containerHeight = container.height();
        
        var anchorOffset = $(e.currentTarget).offset();

        dropdown.css({
          'right': containerWidth / 2 + 'px',
          'position' : 'absolute',
          'z-index' : 100
        })
        
        container.toggleClass('expanded')
        
      });

//Close dropdowns on document click

$(document).on('click', '#dropdownOverlay', function(e){
  var el = $(e.currentTarget)[0].activeElement;
  
  if(typeof $(el).attr('data-dropdown') === 'undefined'){
    $('#dropdownOverlay').remove();
    $('.dropdown-container.expanded').removeClass('expanded');
  }
})

//Dropdown collapsile tabs
$('.notification-tab').click(function(e){
  if($(e.currentTarget).parent().hasClass('expanded')){
    $('.notification-group').removeClass('expanded');
  }
  else{
    $('.notification-group').removeClass('expanded');
    $(e.currentTarget).parent().toggleClass('expanded');
  }
})
</script>

<script type="text/javascript">
  $( document ).ready(function() {
//var user_id = Session::getId();

var id = "user_id";

    $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
   });

   $.ajax({
     url: '{{ url('/user/notifications') }}',    
     type:"POST",
     dataType:"json",
     async: false,
     data: {id: id, _token: '{{csrf_token()}}'},
     success:function(data){


      // console.log(data);

     // return false;   
      
       var data2 = data;
      
       
       // <div class = ""><a onclick="notification('+work_flow_id+')" style="width: 100%;border-bottom: 1px solid #adb5bd;"><div class = "notification-text">'+ data['rowsdetails'][count].work_flow_name +' '+ data['rowsdetails'][count].work_flow_level_name +' allocated to you. </div></a></div>

     $('.user_login_name').text(''+ data2['user'][0].name +'');
       //console.log(''+ data2['user'][0].name +'');

       

       var count = data2['count_data'][0].countflow;

       var count1 = data2['work_flow_data_count'][0].countflow;

        var count2 = data2['user_data_count'][0].countflow;

        var count3 = data2['form_data_count'][0].countflow;

        var count4 = data2['payment_data_count'][0].countflow;

        // var count5 = data2['paymentsuccessfull_data_count'][0].countflow;


        var count7 = data2['ovmmeeting_data_count'][0].countflow;


        var count6 = data2['elinademolink_count'][0].countflow;

        var count66 = data2['uamdata_count'][0].countflow;

        var count99 = data2['activity_count'][0].countflow;

        var count77 = data2['questionnaire_count'][0].countflow;
       if (count == 0) {

         
       }else{

        $('.user_name_login').append('<span class="label badgeworkflow">'+ data2['count_data'][0].countflow +'</span>')

       // $('.badgeworkflow').text(''+ data2['count_data'][0].countflow +'');

       $('.user_name_alert').append('<span class="label user_name_alert">'+ count1 +'</span>');

         $('.user_name_alert1').append('<span class="label user_name_alert1">'+ count2 +'</span>');

          $('.user_name_alert2').append('<span class="label user_name_alert2">'+ count3 +'</span>');

          $('.user_name_alert3').append('<span class="label user_name_alert3">'+ count4 +'</span>');

          // $('.user_name_alert4').append('<span class="label user_name_alert4">'+ count5 +'</span>');

          $('.user_name_alert5').append('<span class="label user_name_alert5">'+ count6 +'</span>');


          $('.user_name_alert6').append('<span class="label user_name_alert6">'+ count7 +'</span>');

          $('.uam_alert_list1').append('<span class="label uam_alert_list1">'+ count66 +'</span>');

          $('.questionnaire_alert_list').append('<span class="label questionnaire_alert_list">'+ count77 +'</span>');
          $('.activity_alert_list1').append('<span class="label activity_alert_list1">'+ count99 +'</span>');

         $('.badgeworkflow').text(count);

       }

 //$('.user_name_login').append('<span class="label badgeworkflow">'+ data2['count_data'][0].countflow +'</span>');
       for(var count = 0; count < data2['work_flow_data'].length; count++)
       {

        // var work_flow_id = data2['work_flow_data'][count].work_flow_id;
        // var notification_type = data2['work_flow_data'][count].notification_type;
        // var work_flow_name = data2['work_flow_data'][count].work_flow_name;
        // var notification_status = data2['work_flow_data'][count].notification_status;
        var notification_id = data2['work_flow_data'][count].notification_id;
        var alert_meg = data2['work_flow_data'][count].alert_meg;


    $('.work_flow_alert_list').append('<li onclick="notification('+notification_id+')" class="notification-list-item"><p class="message">'+alert_meg+'</p></li>');

      }
       for(var count = 0; count < data2['user_data'].length; count++)
       {

        // var work_flow_id = data2['work_flow_data'][count].work_flow_id;
        // var notification_type = data2['work_flow_data'][count].notification_type;
        // var work_flow_name = data2['work_flow_data'][count].work_flow_name;
        // var notification_status = data2['work_flow_data'][count].notification_status;
        var notification_id = data2['user_data'][count].notification_id;
        var alert_meg = data2['user_data'][count].alert_meg;


    $('.user_alert_list').append('<li onclick="notification1('+notification_id+')" class="notification-list-item"><p class="message">'+alert_meg+'</p></li>');

      }

      for(var count = 0; count < data2['form_data'].length; count++)
       {

        // var work_flow_id = data2['work_flow_data'][count].work_flow_id;
        // var notification_type = data2['work_flow_data'][count].notification_type;
        // var work_flow_name = data2['work_flow_data'][count].work_flow_name;
        // var notification_status = data2['work_flow_data'][count].notification_status;
        var notification_id = data2['form_data'][count].notification_id;
        var alert_meg = data2['form_data'][count].alert_meg;


    $('.form_alert_list').append('<li onclick="notification2('+notification_id+')" class="notification-list-item"><p class="message">'+alert_meg+'</p></li>');

      }

//      
for(var count = 0; count < data2['payment_data'].length; count++)
       {

        // var work_flow_id = data2['work_flow_data'][count].work_flow_id;
        // var notification_type = data2['work_flow_data'][count].notification_type;
        // var work_flow_name = data2['work_flow_data'][count].work_flow_name;
        // var notification_status = data2['work_flow_data'][count].notification_status;
        var notification_id = data2['payment_data'][count].notification_id;
        var alert_meg = data2['payment_data'][count].alert_meg;


    $('.payment_alert_list').append('<li onclick="notification3('+notification_id+')" class="notification-list-item"><p class="message">'+alert_meg+'</p></li>');

      }

    //   for(var count = 0; count < data2['paymentsuccessfull_data'].length; count++)
    //    {

    //     // var work_flow_id = data2['work_flow_data'][count].work_flow_id;
    //     // var notification_type = data2['work_flow_data'][count].notification_type;
    //     // var work_flow_name = data2['work_flow_data'][count].work_flow_name;
    //     // var notification_status = data2['work_flow_data'][count].notification_status;
    //     var notification_id = data2['paymentsuccessfull_data'][count].notification_id;
    //     var alert_meg = data2['paymentsuccessfull_data'][count].alert_meg;


    // $('.paymentsuccessful_alert_list').append('<li onclick="notification4('+notification_id+')" class="notification-list-item"><p class="message">'+alert_meg+'</p></li>');

    //   }
      for(var count = 0; count < data2['ovmmeeting_data'].length; count++)
       {


        var notification_id = data2['ovmmeeting_data'][count].notification_id;
        var alert_meg = data2['ovmmeeting_data'][count].alert_meg;


    $('.ovm_meeting').append('<li onclick="notification6('+notification_id+')" class="notification-list-item"><p class="message">'+alert_meg+'</p></li>');

      }
      for(var count = 0; count < data2['elinademolink_data'].length; count++)
       {


        // var work_flow_id = data2['work_flow_data'][count].work_flow_id;
        // var notification_type = data2['work_flow_data'][count].notification_type;
        // var work_flow_name = data2['work_flow_data'][count].work_flow_name;
        // var notification_status = data2['work_flow_data'][count].notification_status;


        var notification_id = data2['elinademolink_data'][count].notification_id;
        var alert_meg = data2['elinademolink_data'][count].alert_meg;


    $('.elinademo_alert_list').append('<li onclick="notification5('+notification_id+')" class="notification-list-item"><p class="message">'+alert_meg+'</p></li>');

      }

      for(var count = 0; count < data2['uamdata_data'].length; count++)
       {

        var notification_id = data2['uamdata_data'][count].notification_id;
        var alert_meg = data2['uamdata_data'][count].alert_meg;
          $('.uam_alert_list').append('<li onclick="notification66('+notification_id+')" class="notification-list-item"><p class="message">'+alert_meg+'</p></li>');
      }

      for(var count = 0; count < data2['activity_data'].length; count++)
       {

        var notification_id = data2['activity_data'][count].notification_id;
        var alert_meg = data2['activity_data'][count].alert_meg;
          $('.activity_alert_list').append('<li onclick="notification99('+notification_id+')" class="notification-list-item"><p class="message">'+alert_meg+'</p></li>');
      }

      for(var count = 0; count < data2['questionnaire_data'].length; count++)
       {
        var notification_id = data2['questionnaire_data'][count].notification_id;
        var alert_meg = data2['questionnaire_data'][count].alert_meg;
          $('.questionnaire_alert_list1').append('<li onclick="notification77('+notification_id+')" class="notification-list-item"><p class="message">'+alert_meg+'</p></li>');
      }

    },


    error:function(data){
    //  console.log(data);
   }
 });

});

   function notification(notification_id)
{
   var login_user_id = $('#login_user_id').val();

   var APP_URL = {!! json_encode(url('/')) !!};

       $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });

       var notification_id = notification_id;

       // alert(APP_URL);

       //return false;


   $.ajax({
     url: '{{ url('/user/notification_alert') }}',    
     type:"POST",
     dataType:"json",
     async: false,
     data: {notification_id: notification_id, _token: '{{csrf_token()}}'},
     success:function(data){

    var url = data['work_flow_data'][0].notification_url;

//       var notification_type =  data[0].screen_url;

// var edit = "edit";



     window.location.href = APP_URL+'/'+url;
      


    },

    error:function(data){
    //  console.log(data);
   }
 });
}

   function notification1(notification_id)
{
   var login_user_id = $('#login_user_id').val();

   var APP_URL = {!! json_encode(url('/')) !!};

       $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });

       var notification_id = notification_id;

        // alert(APP_URL);

       //return false;


   $.ajax({
     url: '{{ url('/user/notification_alert') }}',    
     type:"POST",
     dataType:"json",
     async: false,
     data: {notification_id: notification_id, _token: '{{csrf_token()}}'},
     success:function(data){

    var url = data['user_data'][0].notification_url;
// console.log(url);
//       var notification_type =  data[0].screen_url;

// var edit = "edit";



     window.location.href = APP_URL+'/'+url;
      


    },

    error:function(data){
      
    //  console.log(data);
   }
 });
}
function notification2(notification_id)
{
   var login_user_id = $('#login_user_id').val();

   var APP_URL = {!! json_encode(url('/')) !!};

       $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });

       var notification_id = notification_id;

        // alert(APP_URL);

       //return false;


   $.ajax({
     url: '{{ url('/user/notification_alert') }}',    
     type:"POST",
     dataType:"json",
     async: false,
     data: {notification_id: notification_id, _token: '{{csrf_token()}}'},
     success:function(data){
      // console.log(data);

    var url = data['form_data'][0].notification_url;
// console.log(url);

//       var notification_type =  data[0].screen_url;

// var edit = "edit";



     window.location.href = APP_URL+'/'+url;
      


    },

    error:function(data){
      
    //  console.log(data);
   }
 });
}

function notification3(notification_id)
{
   var login_user_id = $('#login_user_id').val();

   var APP_URL = {!! json_encode(url('/')) !!};

       $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });

       var notification_id = notification_id;

        // alert(APP_URL);

       //return false;


   $.ajax({
     url: '{{ url('/user/notification_alert') }}',    
     type:"POST",
     dataType:"json",
     async: false,
     data: {notification_id: notification_id, _token: '{{csrf_token()}}'},
     success:function(data){

    var url = data['payment_data'][0].notification_url;
// console.log(url);

//       var notification_type =  data[0].screen_url;

// var edit = "edit";



     window.location.href = APP_URL+'/'+url;
      


    },

    error:function(data){
      
    //  console.log(data);
   }
 });
}

// function notification4(notification_id)
// {
//    var login_user_id = $('#login_user_id').val();

//    var APP_URL = {!! json_encode(url('/')) !!};

//        $.ajaxSetup({
//      headers: {
//        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//      }
//    });

//        var notification_id = notification_id;

//         // alert(APP_URL);

//        //return false;


//    $.ajax({
//      url: '{{ url('/user/notification_alert') }}',    
//      type:"POST",
//      dataType:"json",
//      async: false,
//      data: {notification_id: notification_id, _token: '{{csrf_token()}}'},
//      success:function(data){

//     var url = data['paymentsuccessfull_data'][0].notification_url;
//   // console.log(url);

//   //       var notification_type =  data[0].screen_url;

//   // var edit = "edit";



//      window.location.href = APP_URL+'/'+url;
      


//     },

//     error:function(data){
      
//     //  console.log(data);
//    }
//  });
// }

function notification6(notification_id)
{
   var login_user_id = $('#login_user_id').val();

   var APP_URL = {!! json_encode(url('/')) !!};

       $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });

       var notification_id = notification_id;

        // alert(APP_URL);

       //return false;

   $.ajax({
     url: '{{ url('/user/notification_alert') }}',    
     type:"POST",
     dataType:"json",
     async: false,
     data: {notification_id: notification_id, _token: '{{csrf_token()}}'},
     success:function(data){
      
// console.log(data);
    
  // console.log( data['ovmmeeting_data'][0]);
  var url = data['ovmmeeting_data'][0].notification_url;

  //       var notification_type =  data[0].screen_url;

  // var edit = "edit";



     window.location.href = APP_URL+'/'+url;
      


    },

    error:function(data){
      
    //  console.log(data);
   }
 });
}
function notification66(notification_id)
{
   var login_user_id = $('#login_user_id').val();

   var APP_URL = {!! json_encode(url('/')) !!};

       $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });
   var notification_id = notification_id;

   $.ajax({
     url: '{{ url('/user/notification_alert') }}',    
     type:"POST",
     dataType:"json",
     async: false,
     data: {notification_id: notification_id, _token: '{{csrf_token()}}'},
     success:function(data){
    var url = data['uamdata_data'][0].notification_url;
    // console.log(url);
     window.location.href = APP_URL+'/'+url;     
    },
    error:function(data){
    //  console.log(data);
   }
 });
}

function notification99(notification_id)
{
   var login_user_id = $('#login_user_id').val();

   var APP_URL = {!! json_encode(url('/')) !!};

       $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });
   var notification_id = notification_id;

   $.ajax({
     url: '{{ url('/user/notification_alert') }}',    
     type:"POST",
     dataType:"json",
     async: false,
     data: {notification_id: notification_id, _token: '{{csrf_token()}}'},
     success:function(data){
    var url = data['activity_data'][0].notification_url;
    // console.log(url);
     window.location.href = APP_URL+'/'+url;     
    },
    error:function(data){
    //  console.log(data);
   }
 });
}

function notification77(notification_id)
{
   var login_user_id = $('#login_user_id').val();

   var APP_URL = {!! json_encode(url('/')) !!};

       $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });
   var notification_id = notification_id;

   $.ajax({
     url: '{{ url('/user/notification_alert') }}',    
     type:"POST",
     dataType:"json",
     async: false,
     data: {notification_id: notification_id, _token: '{{csrf_token()}}'},
     success:function(data){
    var url = data['questionnaire_data'][0].notification_url;
    // console.log(url);
     window.location.href = APP_URL+'/'+url;     
    },
    error:function(data){
    //  console.log(data);
   }
 });
}

</script>
@include('layouts.script')

</body>


</html>