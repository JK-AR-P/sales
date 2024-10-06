const form = function () {
    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: true,
        progressBar: true,
        positionClass: "toast-bottom-right",
        preventDuplicates: false,
        onclick: null,
        showDuration: 300,
        hideDuration: 1000,
        timeOut: 5000,
        extendedTimeOut: 1000,
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "slideDown",
        hideMethod: "fadeOut",
    };

    $("form.xform").each(function () {
        let form = $(this);
        form.attr("onsubmit", "return false");

        form.off("submit").on("submit", function (event) {
            event.preventDefault(); // Prevent default form submission

            form.find(".submit").prop("disabled", true);
            Pace.start();
            let action = form.attr("action"),
                method = form.attr("method");

            var data = new FormData(this);
            $.each($(this).data(), function (name, value) {
                data.append(name, value);
            });

            form.trigger("xform-submit", [data]);

            Pace.start();
            $.ajax({
                url: action,
                type: method,
                data: data,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    Swal.fire({
                        title: "On progress...",
                        html: "Please wait...",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });
                },
                success: function (res) {
                    Pace.stop();
                    Swal.close();

                    let fields = [
                        form.find("input"),
                        form.find("select"),
                        form.find("textarea"),
                    ];

                    for (i in fields) {
                        fields[i].removeClass("is-invalid");
                        fields[i]
                            .parent()
                            .find("span.invalid-feedback")
                            .remove();
                    }

                    if (res.status === "success") {
                        form.trigger("xform-success", [res]);
                    } else if (res.status === "error") {
                        $(".card-login")
                            .removeClass("animate__zoomInUp")
                            .addClass("animate__jello");
                        form.trigger("xform-error", [res]);
                    }

                    if (res.resets) {
                        if ("all" === res.resets) {
                            form.trigger("reset");
                            form.find("label.custom-file-label").html(
                                "Choose file"
                            );
                        } else {
                            for (let i in res.resets) {
                                let name = res.resets[i];
                                form.find('input[name="' + name + '"]').val("");
                                form.find('select[name="' + name + '"]').val("");
                                form.find('textarea[name="' + name + '"]').html("");
                                form.find("label.custom-file-label").html("");
                            }
                        }
                    }

                    if (res.errors) {
                        let focus_first_error_field = true;
                        for (let field in res.errors) {
                            let message = res.errors[field][0];
                            console.log("message", message);
                            // Process input fields
                            let input = form.find(`input[name="${field}"]`);
                            if (input.length > 0) {
                                input.addClass("is-invalid");
                                input.parent().append(`<span class="invalid-feedback">${message}</span>`);
                                if (focus_first_error_field) {
                                    input.focus();
                                    focus_first_error_field = false;
                                }
                            }

                            // Process select fields
                            let select = form.find(`select[name="${field}"]`);
                            if (select.length > 0) {
                                select.addClass("is-invalid");
                                select.parent().append(`<span class="invalid-feedback">${message}</span>`);
                                if (focus_first_error_field) {
                                    select.focus();
                                    focus_first_error_field = false;
                                }
                            }

                            // Process textarea fields
                            let textarea = form.find(`textarea[name="${field}"]`);
                            if (textarea.length > 0) {
                                textarea.addClass("is-invalid");
                                textarea.parent().append(`<span class="invalid-feedback">${message}</span>`);
                                if (focus_first_error_field) {
                                    textarea.focus();
                                    focus_first_error_field = false;
                                }
                            }
                        }
                    }

                    if (res.toast) {
                        if ("success" == res.status) {
                            toastr.success(res.toast);
                        } else if ("info" == res.status) {
                            toastr.info(res.toast);
                        } else if ("error" == res.status) {
                            toastr.error(res.toast);
                        } else if ("warning" == res.status) {
                            toastr.warning(res.toast);
                        }
                    }

                    if (res.redirect) {
                        setTimeout(function () {
                            toastr.info("Redirecting...");
                        }, 1000);
                        setTimeout(function () {
                            window.location.href = res.redirect;
                        }, 2000);
                    }
                },
                error: function (err) {
                    console.log(err);
                    form.find(".submit").prop("disabled", false);
                    Pace.stop();
                    Swal.close();

                    if (err.responseJSON) {
                        toastr.error(
                            err.statusText + " | " + err.responseJSON.message
                        );
                    } else {
                        toastr.error(err.statusText);
                    }
                },
            });
        });
    });
};

const TriggerReset = function (form) {
    form.trigger("reset");

    let fields = [
        form.find("input"),
        form.find("select"),
        form.find("textarea"),
    ];

    for (i in fields) {
        fields[i].removeClass("is-invalid");
        fields[i].parent().find("span.invalid-feedback").remove();
    }
    $(".card-login").removeClass("animate__jello");
};

form();
