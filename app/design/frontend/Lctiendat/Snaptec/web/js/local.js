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

    // $(".recommendations .product button.add-to-cart").click(function (e) {
    //     e.preventDefault();
    //     const antiCsrf = $(
    //         '.recommendations .product input[name="form_key"][type="hidden"]'
    //     )
    //         .val()
    //         .trim();
    //     const id = $(this).data("id");
    //     const url = `/checkout/cart/add/product/${id}`;
    //     $.post(url, {
    //         form_key: antiCsrf,
    //     });
    // });

    // $(".recommendations .product i.add-to-wishlist").click(function (e) {
    //     console.log("vcl");
    //     const antiCsrf = $(
    //         '.recommendations .product input[name="form_key"][type="hidden"]'
    //     )
    //         .val()
    //         .trim();
    //     const id = $(this).siblings("button").data("id");
    //     const url = `/wishlist/index/add/product/${id}`;
    //     $.post(url, {
    //         form_key: antiCsrf,
    //     });
    // });
});
