require(["jquery"], function ($) {
    $(".link.authorization-link").mouseenter(function () {
        $(".show-menu-logged").removeClass("d-none");
    });
    $(".link.authorization-link").mouseleave(function () {
        $(".show-menu-logged").addClass("d-none");
    });

    $(document).scroll(function () {
        const scroll = $(this).scrollTop();
        const topDist = $("#maincontent").position();
        if (scroll > topDist.top) {
            $(".header-nav").css({ position: "fixed", top: "30px" });
        } else {
            $(".header-nav")
                .css({ position: "static", top: "auto" })
                .addClass("fixed-navbar");
        }
    });

    $("i.add-to-wishlist").click(function (e) {
        e.preventDefault();
        const form = $(this).closest("form");
        const id = form.attr("data-id");

        var url = "/wishlist/index/add/";
        var data = {
            action: "add-to-wishlist",
            form_key: $('input[name="form_key"]').val().trim(),
            product: id,
        };

        $.post(url,data)
    });
});
