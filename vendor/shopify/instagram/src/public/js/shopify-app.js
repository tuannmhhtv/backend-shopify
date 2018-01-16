(function () {
    $(function () {
        var n, t, o, c;
        return c = function () {
            return o() ? ($(document.body).addClass("token-received"), t()) : $(document.body).addClass("no-token"), n()
        }, o = function () {
            var n;
            return n = window.location.hash, !!(n.length && n.indexOf("access_token") > -1)
        }, t = function () {
            var n;
            return n = window.location.hash.split("#access_token=")[1], $(".instagram-access-token").val(n).on("click", function () {
                return $(this).select()
            })
        }, n = function () {
            return Modernizr.svg ? void 0 : $(".logo").attr("src", $(".logo").data("backup-png"))
        }, c()
    })
}).call(this);
