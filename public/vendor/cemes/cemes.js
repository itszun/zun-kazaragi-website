`use strict`;

$.CleanNumber = (string) => string.toString().replace(/\D+/g, "");
$.FormatCurrency = (num) => Intl.NumberFormat("en-US").format(num);

$.prototype.cemes = function (name) {
    return $(this).attr(`cemes-${name}`);
};

$.prototype.cleanVal = function () {
    return $.CleanNumber($(this).val());
};

$.prototype.castVal = function (value) {
    const el = $(this);
    const len = el.length;
    const casting = (el, value) => {
        const cast = el.cemes("cast");
        const caster = Cemes.cast[cast];
        const val = typeof caster === "function" ? caster(el, value) : el.val(); // if it casting and not
        return { el: el, val: val };
    };
    const castingMap = (k, v) => {
        return casting($(v), value).el;
    };

    return value & (el.length > 1)
        ? el.map(castingMap)
        : casting(el, value).val;
};

$.prototype.castSerializeArray = function () {
    const fi = $(this).find(`
        input:not([type="radio"]), input[type="radio"]:checked, select, textarea
    `); // Field Inputs
    const check = (k, v) => {
        Cemes.log("Check");
        const el = $(v);
        if (el.attr("disabled")) return;
        const name = el.attr("name") || "undefined";
        const isArray = name.match(/\[\]$/) !== null;
        const x = {
            name: name.replace("[]", ""),
            value: $(v).castVal(),
            isArray: isArray,
        };
        Cemes.log(x);
        return x;
    };
    const convert = (acc, i) => {
        if (i.isArray) {
            acc[i.name] = acc[i.name] === undefined ? [] : acc[i.name];
            return Object.assign(acc, { [i.name]: [...acc[i.name], i.value] });
        }
        return Object.assign(acc, { [i.name]: i.value });
    };
    const keyVal = fi.map(check).toArray();
    const data = keyVal.reduce(convert, {});
    return data;
};

$.prototype.CemesForm = function () {
    const $el = $(this);
    Cemes.log("CEMES FORM INIT");
    $el.submit(async (e) => {
        Cemes.log("CEMES FORM SUBMIT");
        e.preventDefault();
        const el = $(e.target);
        const confirm = el.find("[cemes-confirm]");
        const next =
            confirm.length > 0 ? await Cemes.confirmDialog(confirm) : true;
        if (!next) return;
        const method = el.cemes("method") || el.attr("method");
        const url = el.attr("action");
        const data = el.castSerializeArray();
        const redirect = el.cemes("redirect");
        Cemes.request(method, url, data);
        Cemes.redirectTo = redirect || "reload";
    });
};
const Cemes = {};
Cemes.debug = false;
Cemes.log = function (...$var) {
    if (!Cemes.debug) return;
    Cemes.log(...$var);
};
Cemes.resource =  {
    "spinner" : `<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgb(255, 255, 255); display: block; shape-rendering: auto;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
    <g transform="rotate(0 50 50)">
      <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.9166666666666666s" repeatCount="indefinite"/>
      </rect>
    </g><g transform="rotate(30 50 50)">
      <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.8333333333333334s" repeatCount="indefinite"/>
      </rect>
    </g><g transform="rotate(60 50 50)">
      <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.75s" repeatCount="indefinite"/>
      </rect>
    </g><g transform="rotate(90 50 50)">
      <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.6666666666666666s" repeatCount="indefinite"/>
      </rect>
    </g><g transform="rotate(120 50 50)">
      <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.5833333333333334s" repeatCount="indefinite"/>
      </rect>
    </g><g transform="rotate(150 50 50)">
      <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.5s" repeatCount="indefinite"/>
      </rect>
    </g><g transform="rotate(180 50 50)">
      <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.4166666666666667s" repeatCount="indefinite"/>
      </rect>
    </g><g transform="rotate(210 50 50)">
      <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.3333333333333333s" repeatCount="indefinite"/>
      </rect>
    </g><g transform="rotate(240 50 50)">
      <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.25s" repeatCount="indefinite"/>
      </rect>
    </g><g transform="rotate(270 50 50)">
      <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.16666666666666666s" repeatCount="indefinite"/>
      </rect>
    </g><g transform="rotate(300 50 50)">
      <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.08333333333333333s" repeatCount="indefinite"/>
      </rect>
    </g><g transform="rotate(330 50 50)">
      <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fe718d">
        <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="0s" repeatCount="indefinite"/>
      </rect>
    </g>
    <!-- [ldio] generated by https://loading.io/ --></svg>`
}

Cemes.cast = {};
Cemes.cast.price = (el, value) => {
    // Cemes.log("CAST PRICE")
    if (value) {
        return el.val($.FormatCurrency($.CleanNumber(value)));
    }
    const dirtyCurrentVal = el.val();
    const cleanedCurrentVal = $.CleanNumber(dirtyCurrentVal);
    const formatCurrentVal = $.FormatCurrency(cleanedCurrentVal);
    el.val(formatCurrentVal);
    return cleanedCurrentVal;
};
Cemes.cast.discount = (el, value) => {
    // Cemes.log("CAST DISCOUNT")
    const val = value === undefined ? el.cleanVal() : value;
    const [a, b] = [val < 0, val > 100];
    const result = a | b ? a * 0 + b * 100 : Intl.NumberFormat().format(val);
    el.val(result);
    return parseInt(result);
};

Cemes.request = async function (method, url, data) {
    const sup = ["POST", "GET"].includes(method.toUpperCase());
    if (!sup) return;
    const result = await Cemes[method.toLowerCase()](url, data);
    return result;
};

Cemes.post = async function (url, data) {
    $(".input-error-text").remove();
    $.ajaxSetup({
        processData: true,
        contentType: "application/json",
    });
    $.LoadingOverlay("show");

    const response = await $.post(url, JSON.stringify(data))
        .done((data) => {
            Cemes.successResponse(data);
            Cemes.log(data);
            return data;
        })
        .fail((err) => {
            Cemes.errorResponse(err);
            console.error(err);
            return err;
        })
        .always(() => {
            $.LoadingOverlay("hide");
        });

    return response;
};

Cemes.get = async function (url, data) {
    Carsell.ClearErrorText();
    $.ajaxSetup({
        processData: true,
        contentType: "application/x-www-form-urlencoded",
    });
    let result = await $.get(url, data)
        .done((data) => {
            return data.result;
        })
        .fail((err) => {
            Cemes.errorResponse(err);
            Cemes.log(err);
        });

    return result;
};

Cemes.delete = async function (url) {
    console.log(url);
    let result = await $.ajax({
        url: url,
        type: "DELETE",
        success: function (res) {
            console.log(res);
            return res;
        },
    });
    return result;
};

Cemes.errorResponse = function (data) {
    const res = data.responseJSON;
    let message = "";
    if (
        $.isArray(res.error_message) |
        (typeof res.error_message === "object")
    ) {
        for (const key in res.error_message) {
            var value = res.error_message[key];
            $(input_error_text(value[0])).insertAfter(
                `input[id="${key}"], select[id="${key}"], textarea[id="${key}"]`
            );
            message += value[0] + "<br/>";
        }
    } else {
        message = res.error_message;
    }

    swal({
        type: "error",
        html: message,
        allowOutsideClick: false,
    }).catch(swal.noop);
};

Cemes.successResponse = function (res) {
    const defaultMessage = "Data berhasil diproses";
    let message = res.detail
        ? res.detail.message || defaultMessage
        : defaultMessage;
    let apiRedirectTo = res.detail.redirectUrl;
    swal({
        type: "success",
        html: message,
        allowOutsideClick: false,
    })
        .then((result) => {
            if (Cemes.redirectTo == "reload") {
                location.reload();
                return;
            }
            if (Cemes.redirectTo == "api") {
                window.location.href = apiRedirectTo;
                return;
            }
            window.location.href = Cemes.redirectTo;
        })
        .catch((any) => {
            Cemes.log(any);
        });
};

Cemes.Discounter = function ({ priceField, discountField, resultField } = {}) {
    if (!priceField.length || !discountField.length || !resultField.length)
        return;
    Cemes.log("CEMES DISCOUNTER INIT");
    Cemes.storeDiscount = {
        priceField: priceField,
        discountField: discountField,
        resultField: resultField,
        discount: discountField.cleanVal(),
    };

    Cemes.countProcessedDiscount();
    discountField.on("keyup change", Cemes.countProcessedDiscount);
    priceField.on("keyup change", Cemes.countProcessedDiscount);
};

Cemes.discountRuled = function (e) {
    const el = $(e.target);
    el.val($.CleanNumber(el.val()));
};

Cemes.storeDiscount = {
    priceField: undefined,
    discountField: undefined,
    displayField: undefined,
    price: 0,
    discount: 0,
    result: 0,
};

Cemes.countProcessedDiscount = function () {
    const { priceField, discountField, resultField, ...clean } =
        Cemes.storeDiscount;
    const price = priceField.castVal();
    const discount = discountField.castVal();
    const result = parseInt(price - price * (discount / 100));
    resultField.castVal(result);
    Cemes.storeDiscount = {
        ...Cemes.storeDiscount,
        price: price,
        discount: discount,
        result: result,
    };
    Cemes.log("COUNT PROCESSED", result);
    Cemes.log(Cemes.storeDiscount);
    Cemes.log("Count Price after discount");
};

Cemes.init = function () {
    // $('[cemes-cast]').castVal()
    $("[cemes-cast]").on("keyup change", (e) => {
        $(e.target).castVal();
    });
    if ($('form[cemes="form"]').length) {
        $('form[cemes="form"]').CemesForm();
    }
    Cemes.Discounter({
        priceField: $("input#price"),
        discountField: $("input#discount"),
        resultField: $("input#price_after_discount"),
    });

    if ($('[cemes="modal"]').length) {
        Cemes.Modal($('[cemes="modal"]'));
    }
    if ($('[cemes="datatable"]').length) {
        Cemes.DataTable($('[cemes="datatable"]'));
    }
};

Cemes.confirmDialog = async function (e) {
    const el = $(e);
    const result = await swal({
        text: el.cemes("confirm"),
        type: "warning",
        showCancelButton: true,
    })
        .then((res) => {
            Cemes.log(res);
            return res;
        })
        .catch((any) => false);
    return result;
};

Cemes.Modal = (el) => {
    const $el = $(el);

    $el.click((e) => {
        e.preventDefault();
        const s = $(e.target);
        const target = s.cemes("target");
        $(`div.modal${target}`).modal("show");
    });
};

Cemes.createDataTable = function ($el, config, setOrder, ajax) {
    Cemes.log("CREATE DATATABLE");
    $el.dataTable().fnDestroy();
    $el.DataTable({
        ...Cemes.commonDatatable,
        ...config,
        ...setOrder,
        ajax,
    });
};

Cemes.commonDatatable = {
    lengthChange: false,
    searching: false,
    fixedHeader: true,
    processing: true,
    serverSide: true,
    language: {
        processing: "Memproses data...",
        search: "Cari Kata Kunci",
        lengthMenu: "Menampilkan _MENU_ data",
        info: "Tampilkan _START_ sampai _END_ dari _TOTAL_ data",
        infoEmpty: "Tabel Kosong",
        infoFiltered: "(Terfilter dari total _MAX_ data)",
        infoPostFix: "",
        loadingRecords: "Memproses data...",
        zeroRecords: "Data tidak ditemukan",
        emptyTable: "Tabel kosong",
        paginate: {
            first: "Awal",
            previous: "Sebelumnya",
            next: "Selanjutnya",
            last: "Terakhir",
        },
        aria: {
            sortAscending: ": Urutkan dari terkecil ke terbesar",
            sortDescending: ": Urutkan dari terbesar ke terkecil",
        },
    },
    columnDefs: [
        {
            targets: "no-sort",
            orderable: false,
        },
    ],
    order: [[1, "desc"]],
};

Cemes.timeout = null;
Cemes.datatableStatusInit = false;

Cemes.DataTable = (el, config = {}) => {
    Cemes.log("DATATABLE INIT");
    const $el = $(el);
    const $filterEl = $($el.cemes("filter-form"));
    const columnDataReducer = (acc, i) => {
        acc.push({ data: i });
        return acc;
    };
    if (Cemes.datatableStatusInit == false) {
        $filterEl.change((e) => {
            clearTimeout(Cemes.timeout);
            Cemes.timeout = setTimeout(() => {
                Cemes.DataTable($el);
            }, 500);
        });
        Cemes.datatableStatusInit = true;
    }
    const columns = JSON.parse($el.cemes("columns")).reduce(
        columnDataReducer,
        []
    );
    Object.assign(config, { columns: columns });
    const url = $el.cemes("source-url");
    const defaultOrder = $el.data("default-order-index") || "";
    const setOrder = {
        order: [[defaultOrder != "" ? defaultOrder : 2, "desc"]],
    };
    let filterData = $filterEl != null ? $filterEl.castSerializeArray() : null;
    let ajax = {
        url: url,
        type: "GET",
        data: {
            search: {
                keyword: $("#keyword").val(),
            },
            ...filterData,
        },
    };
    Cemes.createDataTable($el, config, setOrder, ajax);
};

Cemes.deleteItem = function ($type) {
    event.preventDefault();
    const el = $(event.target);
    const url = el.attr("href");
    swal({
        title: "Yakin untuk menghapus?",
        text: "Anda tidak dapat mengembalikan Item ini",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batalkan!",
    })
        .then(function (isConfirm) {
            console.log(isConfirm);
            if (isConfirm) {
                console.log(isConfirm);
                swal({
                    title: "Memproses..",
                    html: Cemes.resource.spinner,
                    showConfirmButton: false,
                });
                Cemes.delete(url).then(() => {
                    swal.close();
                    swal({
                        title: "Menghapus Data!",
                        type: "success",
                        text: "Data Berhasil Dihapus",
                    })
                        .then(() => {
                            el.parents('[cemes="datatable"]')
                                .DataTable()
                                .ajax.reload(() => {
                                    Cemes.log("Reload");
                                }, false);
                        })
                        .catch(() => {
                            el.parents('[cemes="datatable"]')
                                .DataTable()
                                .ajax.reload(() => {
                                    Cemes.log("Reload");
                                }, false);
                        });
                });
            } else {
                swal("Cancelled", "Your file is safe :)", "error");
            }
        })
        .catch((e) => {
            Cemes.log(e);
        });
};

$(document).ready(function () {
    Cemes.init();
    // console.log("UWU");
    datatableAjaxRequest($(".datatable-ajax"));
    $("form.data-table-search").submit(function (e) {
        e.preventDefault();
        datatableAjaxRequest($(".datatable-ajax"));
    });

    $("form.data-table-change").submit(function (e) {
        e.preventDefault();
        datatableAjaxRequest($(".datatable-ajax"));
    });
    $("form.data-table-change").change(function (e) {
        e.preventDefault();
        datatableAjaxRequest($(".datatable-ajax"));
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("input.numberThousand").keyup((event) => {
        let el = $(event.target);
        // let val = formatRibuan(el.val());
        el.val(val);
    });

    // $('input.numberYear').keyup((event) => {
    //     let el = $(event.target);
    //     let val = formatTahun(el.val());
    //     el.val(val)
    // })
    if ($.prototype.datepicker) {
        $("input.datepicker-year").datepicker({
            format: " dd/mm/yyyy",
            viewMode: "year",
            autoclose: true,
            todayHighlight: true,
            calendarWeeks: false,
            startView: 0,
            todayBtn: "linked",
        });
    }

    $("input.upload-banner").change(async (event) => {
        console.log("OWO)/)");
        let el = $(event.target);
        let uploadUrl = el.data("carshow-url");
        let image = el.prop("files")[0];
        let context = el.attr("id");

        let preview = $(`.file-upload-preview#${context}-preview`);
        preview.attr("src", "");

        let formData = new FormData();
        formData.append("userfile", image);
        let upload = await ajax_upload(uploadUrl, formData);
        if (!upload) {
            return true;
        }
        if (el.prop("files").length > 0) {
            let src = URL.createObjectURL(el.prop("files")[0]);
            preview.attr("src", src);
        }
        let inputTarget = el.data("input-target");
        $("input#" + inputTarget).val(upload[inputTarget]);
    });

    $("input.file-upload").change(async (event) => {
        let el = $(event.target);
        let uploadUrl = el.data("carshow-url");
        let image = el.prop("files")[0];
        let context = el.attr("id");

        let preview = $(`.file-upload-preview#${context}-preview`);
        preview.attr("src", "");

        let formData = new FormData();
        formData.append("userfile", image);
        formData.append("context", context);
        console.log(formData);

        let upload = await ajax_upload(uploadUrl, formData);
        if (!upload) {
            return true;
        }
        if (el.prop("files").length > 0) {
            let src = URL.createObjectURL(el.prop("files")[0]);
            preview.attr("src", src);
        }
        $(el.data("input-target")).attr("value", upload);
    });

    $("form.ajax_post").submit(submitAction);
});

const submitAction = async function (event) {
    event.preventDefault();
    let el = $(event.target);
    let action = el.attr("action");
    let formData = el.serialize();
    console.log(formData);

    let request = await ajax_post(action, formData);
    let indexUrl = el.data("index-url") || null;
    if (!request) {
        console.log("Failed");
        return "x";
    }

    const defaultMessage = "Data berhasil diproses";
    message = request.detail
        ? request.detail.message || defaultMessage
        : defaultMessage;
    if (request.detail.redirectUrl !== undefined) {
        indexUrl = request.detail.redirectUrl;
    }
    swal({
        type: "success",
        html: message,
        allowOutsideClick: false,
    })
        .then((result) => {
            if ((indexUrl != null) & (indexUrl != window.location.href)) {
                console.log("REDIRECTING >w<");
                window.location.href = indexUrl;
            } else {
                console.log("RELOAD OwO>");
                location.reload();
            }
            // console.log("UwU")
        })
        .catch((any) => {
            console.log(any);
        });
};

async function ajax_upload(uploadUrl, formData) {
    clear_error_text();
    $.ajaxSetup({
        processData: false,
        contentType: false,
    });
    let status;
    await $.post(uploadUrl, formData)
        .done((data) => {
            res = data.result;
            console.log(res);
        })
        .fail((err) => {
            console.log(err);
            window.error_response(err);
            res = false;
        });
    return res;
}

async function ajax_get(getUrl, data, config = {}) {
    clear_error_text();
    var result = false;
    $.ajaxSetup({
        processData: true,
        contentType: "application/x-www-form-urlencoded",
    });
    await $.get(getUrl, data)
        .done((data) => {
            console.log(data);
            result = data.result;
            console.log(result);
            return result;
        })
        .fail((err) => {
            if (config.reportError == false) {
                return;
                console.log("CONFIG ", config);
            }
            window.error_response(err);
            console.log(err);
        });

    return result;
}

async function ajax_post(postUrl, formData) {
    clear_error_text();
    var response;
    $.ajaxSetup({
        processData: true,
        contentType: "application/x-www-form-urlencoded",
    });
    $.LoadingOverlay("show");

    await $.post(postUrl, formData)
        .done((data) => {
            console.log(data);
            response = data;
        })
        .fail((err) => {
            window.error_response(err);
            response = err;
        })
        .always(() => {
            $.LoadingOverlay("hide");
        });
    $.LoadingOverlay("hide");

    return response;
}

function input_error_text(message) {
    let html = `<small class="form-text text-danger input-error-text">${message}</small>`;
    return html;
}

function clear_error_text() {
    $(".input-error-text").remove();
}

window.error_response = (data) => {
    let errTarget = $("#errorBox");
    let res = $.parseJSON(data.responseText);
    let message = "";
    if (
        $.isArray(res.error_message) |
        (typeof res.error_message === "object")
    ) {
        for (const key in res.error_message) {
            var value = res.error_message[key];
            $(input_error_text(value[0])).insertAfter(
                'input[id="' +
                    key +
                    '"], select[id="' +
                    key +
                    '"], textarea[id="' +
                    key +
                    '"]'
            );
            message += value[0] + "<br/>";
        }
    } else {
        message = res.error_message;
    }

    swal({
        type: "error",
        html: message,
        allowOutsideClick: false,
    }).catch(swal.noop);
    // toastr.error(message, 'Validation Error!')
};

$("#ReportModal").on("show.bs.modal", async function (event) {
    // console.log("UwU)/)**");
    $.LoadingOverlay("show");
    let url = $(event.relatedTarget).data("report-url");
    let container = $($(event.target).data("upload-container"));
    console.log(container);
    container.html("");

    if (url === undefined) {
        $("#ReportModal").find($("input")).attr("value", "");
        $("#ReportModal")
            .find($('input[type="checkbox"]'))
            .removeAttr("checked");
        $("#ReportModal").find($('input[type="checkbox"]')).attr("value", 1);
        $("#ReportModal").find("#action").attr("value", "visits");
        $.LoadingOverlay("hide");
        $("#ReportModal").find(".prospect").show();
        $("#ReportModal").find(".create-hide").hide();
        return true;
    }

    let request = await ajax_get(url);
    if (!request) {
        console.log("Error");
        return false;
    }
    let selection = "";
    let type = "";

    let selectObj = $(".modal-select2");
    // console.log("0w0)/)))))")
    selectObj.each((key, value) => {
        let dom = $(value);
        let url = dom.data("url");
        $.get(url)
            .done((data) => {
                let option = data.result;
                type = data.detail;
                if (type !== "") {
                    selection = request[`${type}_id`];
                }
                console.log(data);
                console.log(selection, type);
                Object.keys(option).forEach((k, i) => {
                    let selected =
                        parseInt(k) !== parseInt(selection) ? "" : "selected";
                    let opt = `<option value="${k}" ${selected}>${option[k]}</option>`;
                    dom.append(opt);
                });
            })
            .always(console.log("=w=)/)"));
    });
    selectObj.select2();

    var action = request.action;
    var date = request.created_at;
    $("#ReportModal").find(`.${action}`).show();
    $("#ReportModal").find($("#action")).attr("value", action);
    $("#ReportModal")
        .find($("#showroom_id"))
        .attr("value", request["showroom_id"]);
    $("#ReportModal")
        .find($("#product_id"))
        .attr("value", request["product_id"]);
    $("#ReportModal").find($("#sales_id")).attr("value", request["sales_id"]);
    $("#ReportModal")
        .find("#modal_title")
        .html(action + ` (${request.poin} Poin)`);
    $("#ReportModal")
        .find("#created_at")
        .html(moment(date).format("dddd, D MMM YYYY"));
    console.log(request);
    let act = request[action];
    console.log("ACTION", request[action] ? request[action].notes : null);
    $("#ReportModal").find("#action").attr("value", request["action"]);

    if ((action == "prospect") | (action == "maintain")) {
        $("#ReportModal").find("#id").attr("value", request["id"]);
        if (act !== null) {
            $("#ReportModal")
                .find("#notes")
                .attr("value", request[action].notes);
            $("#ReportModal")
                .find("#gps_locator")
                .attr("value", request[action].gps_locator);
        }
        $("#ReportModal")
            .find("#is_approve")
            .prop("checked", request.is_approve);
        for (let i = 0; i < request.attachment.length; i++) {
            let el = request.attachment[i];
            console.log($(event.target).find("form"));
            container.append(
                DocumentationPicturePreview(el.filename, el.filename_url)
            );
        }
    }
    if (action == "register") {
        $("#ReportModal").find($("#id")).attr("value", request["id"]);
    }
    if (action == "iklan") {
        $("#ReportModal").find($("#id")).attr("value", request["id"]);
    }
    if (action == "inspeksi") {
        $("#ReportModal").find($("#id")).attr("value", request["id"]);
    }
    if (action == "garansi") {
        $("#ReportModal").find($("#id")).attr("value", request["id"]);
        if (request[action] !== null) {
            $("#ReportModal")
                .find("#id_inspeksi")
                .attr("value", request[action].id_inspeksi);
            $("#ReportModal")
                .find("#nomor_garansi")
                .attr("value", request[action].nomor_garansi);
            $("#ReportModal")
                .find("#status")
                .attr("value", request[action].status);
        }
    }
    if (request.sales !== null) {
        $("#ReportModal")
            .find($("#sales_name"))
            .attr("value", request.sales.name);
    }
    $("#ReportModal")
        .find($("#product_name"))
        .attr("value", request.product ? request.product.name : "");
    $("#ReportModal")
        .find($("#showroom_name"))
        .attr("value", request.showroom ? request.showroom.name : "");
    $("#ReportModal")
        .find('input[type="checkbox"]#with_sales')
        .attr("value", 1);
    $("#ReportModal")
        .find('input[type="checkbox"]#with_sales')
        .prop("checked", request.sales);

    $.LoadingOverlay("hide");

    return true;
});

$("#ReportModal").on("hide.bs.modal", function (e) {
    console.log("CLOSING MODAL");
    console.log("HIDING FORM");
    let action = $("#ReportModal").find("#action").attr("value");
    $("#ReportModal").find("#modal_title").html("");
    $("#ReportModal").find("input").attr("value", "");
    $("#ReportModal").find('input[type="checkbox"]').attr("value", 1);
    $("#ReportModal")
        .find("." + action)
        .hide();
});

function searchData(context) {
    data = {
        cars: {
            condition: $("#kondisi").val(),
            is_active: $("#status").val(),
            brand_id: $("#merek").val(),
            name: $("#keyword").val(),

            car_type_id: $("#tipe").val(),
            varian_id: $("#varian").val(),
            store_id: $("#store_id").val(),
        },
        users: {
            role_id: $("#role").val(),
            is_active: $("#status").val(),
            keyword: $("#keyword").val(),
        },
        hubungi_kami: {
            keyword: $("#keyword").val(),
        },
        promos: {
            keyword: $("#keyword").val(),
        },
        news: {
            keyword: $("#keyword").val(),
            publish: $("#publish").val(),
        },
        showroom: {
            keyword: $("#keyword").val(),
            approval: $("#approval").val(),
            membership: $("#membership").val(),
        },
        permohonan_kredit: {
            keyword: $("#keyword").val(),
            kredit_status: $("#kredit_status").val(),
        },
        membership: {
            keyword: $("#keyword").val(),
            kredit_status: $("#kredit_status").val(),
        },
        common: {
            keyword: $("#keyword").val(),
        },
    };
    return data[context];
}

function orderData(context) {
    data = {
        uoms: [[1, "asc"]],
        users: [[1, "asc"]],
        cars: [[5, "desc"]],
        notifications: [[3, "desc"]],
        hubungi_kami: [[6, "asc"]],
        promos: [[4, "desc"]],
        news: [[4, "desc"]],
        banners: [[2, "desc"]],
        showroom: [[4, "desc"]],
        membership: [[1, "desc"]],
        common: [[2, "desc"]],
        "col-4": [[4, "desc"]],
    };
    return data[context];
}

function datatableAjaxRequest(element) {
    for (let i = 0; i < element.length; i++) {
        let el = $(element[i]);
        let ajaxUrl = el.data("ajax-url");
        let context = el.data("ajax-context");
        let paging = el.data("table-paging") || true;
        let lengthChange = el.data("table-sort") || true;
        let searchSource = el.data("search-source") || false;
        let ordering = el.data("table-order") || true;
        let method = el.data("table-method") || "GET";
        let id = el.data("ajax-id");
        var searchData = this.searchData(context);
        el.dataTable().fnDestroy();
        config = {
            processing: true,
            serverSide: true,
            columnDefs: [
                {
                    targets: "no-sort",
                    orderable: false,
                },
                { className: "text-center", targets: [] },
                { className: "text-left", targets: [] },
                { className: "text-right", targets: [] },
            ],
        };
        if (method === "POST") {
            let csrf_token = $("meta[name=csrf-token]").attr("content");
            searchData = {
                ...searchData,
                _token: csrf_token,
            };
        }
        if (searchSource !== false) {
            var searchForm = $(searchSource).serializeArray();

            for (let i = 0; i < searchForm.length; i++) {
                const e = searchForm[i];
                searchData = { ...searchData, [e.name]: e.value };
            }
        }
        console.log(lengthChange);
        // console.log(searchData);
        if (lengthChange == true) {
            config = {
                ...config,
                order: orderData(context),
            };
        }

        if (id) {
            searchData.id = id;
        }

        el.DataTable({
            lengthChange: false,
            searching: false,
            ordering: ordering,
            // 'scrollX': true,
            // 'scrollCollapse' : true,
            paging: paging,
            ...config,
            ajax: {
                url: ajaxUrl,
                type: method,
                data: searchData,
            },
        });
    }
}
function ShowroomPicturePreview(filename, url, id, deleteUrl = null) {
    return `
        <div class="single mr-3 mb-4" style="width: 300px">
            <img src="${url}" alt="[Foto Showroom]" style="height: 200px;width: inherit; object-fit:cover">
            <input hidden name="foto_showroom[]" value="${filename}">
            <button type="button" onclick="uploadCarouselRemove(this)" class="btn btn-sm btn-default btn-block" data-delete-url="${deleteUrl}">Hapus</button>
        </div>
    `;
}

function DocumentationPicturePreview(filename, filename_url, deleteUrl = null) {
    return `
        <div>
            <img class="bg-primary mx-2" style="width: 120px; height: 120px; object-fit: cover" src="${filename_url}">
            <input hidden name="documentation_photo[]" value="${filename}">
            <button type="button" class="btn btn-sm btn-default btn-block" onclick="$(this).parent().remove()"
            data-delete-url="${deleteUrl}">Hapus</button>
        <div>
    `;
}

function ShowroomDocumentPreview(filename, filename_url, deleteUrl = null) {
    return `

    <div class="single mr-3 mb-1 col-12">
        <div class="py-2 w-auto">
            <span class="p-3" style="border: .2px solid #ddd">
                <input hidden name="document_showroom[]" value="${filename}">
                <a href="${filename_url}" target="_blank" class="mr-2"><i class="fa fa-eye"></i> </a>
                <span target="_blank" class="mr-3">${filename}</span>
                <button onclick="uploadCarouselRemove(this)" data-delete-url=""${deleteUrl}" class="btn btn-sm btn-default ">Hapus</button>
            </span>
        </div>
    </div>
`;
}
const cleanNumber = (dirtyNumber) => {
    return dirtyNumber.split(".").join("") * 1;
};
const priceField = $("input#price");
const discountField = $("input#discount");
const displayField = $("input#price_after_discount");

const countProcessedPrice = () => {
    let price = $.CleanNumber(priceField.val());
    let discount = discountField.val();
    let value = parseInt(price - price * (discount / 100));
    displayField.val(formatRibuan(value.toString()));
    console.log("Count Price after discount");
};

// if (
//     (priceField.val() && discountField.val() && displayField.val()) !==
//     undefined
// ) {
//     countProcessedPrice();
// }

// priceField.change(() => {
//     countProcessedPrice();
// });
// discountField.change(() => {
//     countProcessedPrice();
// });

window.first = true;

async function uploadCarouselRemove(el) {
    console.log($(el));
    let url = $(el).data("delete-url");
    console.log(url);
    $.get(url);

    $(el).parent().remove();
}
async function uploadCarousel(event) {
    let input = $(event.target);
    window.data = {
        container: $(input.data("upload-container")),
        files: input[0].files,
        uploadUrl: input.data("upload-url"),
        child_component: input.data("child-component"),
        name: input.data("input-name"),
    };
    if (window.first) {
        if (input.data("no-reset") == false) {
            window.data.container.html("");
            window.first = false;
        }
    }

    for (let i = 0; i < window.data.files.length; i++) {
        const element = window.data.files[i];

        window.data.formData = new FormData();
        window.data.formData.append("userfile", element);

        let res = await file_uploader(
            window.data.uploadUrl,
            window.data.formData
        );
        if (window.data.child_component == "showroom") {
            window.data.container.append(
                ShowroomPicturePreview(
                    res.filename,
                    res.filename_url,
                    res.id,
                    res.delete_url
                )
            );
        } else if (window.data.child_component == "document") {
            window.data.container.append(
                ShowroomDocumentPreview(
                    res.filename,
                    res.filename_url,
                    res.delete_url
                )
            );
        } else {
            window.data.container.append(
                DocumentationPicturePreview(
                    res.filename,
                    res.filename_url,
                    res.delete_url
                )
            );
        }
    }
    //upload data

    //get url file
    //attach preview image to container
}

async function uploadSingle(event) {
    let input = $(event.target);
    window.data = {
        container: $(input.data("upload-container")),
        files: input[0].files,
        uploadUrl: input.data("upload-url"),
        name: input.data("input-name"),
        child_component: input.data("child-component"),
    };

    const element = window.data.files[0];

    window.data.formData = new FormData();
    window.data.formData.append("userfile", element);

    let res = await file_uploader(window.data.uploadUrl, window.data.formData);
    console.log(res.filename_url);
    window.data.container.find("img").attr("src", res.filename_url);
    $(".__" + window.data.name).remove();
    $(`input[name="${window.data.name}"]`).remove();
    window.data.container.find("img").after(`
        <input hidden class="__${window.data.name}" type="text" name="${window.data.name}" value="${res.filename}">
    `);
}

function clear_error_text() {
    $(".input-error-text").remove();
}

async function file_uploader(uploadUrl, formData) {
    clear_error_text();
    $.ajaxSetup({
        processData: false,
        contentType: false,
    });
    let status;
    await $.post(uploadUrl, formData)
        .done((data) => {
            res = data.result;
            return res;
            console.log(res);
        })
        .fail((err) => {
            console.log(err);
            window.error_response(err);
            res = false;
        })
        .always(() => {
            resetAjaxSetup();
            // console.log("UwU");
        });
    return res;
}

function resetAjaxSetup() {
    return $.ajaxSetup({
        processData: true,
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
    });
}

function ajaxUpload() {
    var file_data = $("#userfile").prop("files")[0];
    var ajaxUrl = $("#userfile").data("upload-url");
    var form_data = new FormData();
    form_data.append("userfile", file_data);
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: ajaxUrl,
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: "post",
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        complete: function () {
            $.LoadingOverlay("hide");
        },
        success: function (json) {
            console.log(json);
            if (json.status == "success") {
                // masukan filename ke inputbox untuk di push ke database
                $("#filename").val(json.result);
                // view image
                $("#img_thumbnail").attr(
                    "src",
                    window.location.origin +
                        "/storage/uploads/temps/" +
                        json.result
                );
            } else {
                swal({
                    type: "error",
                    title: "Error",
                    html: json.error_message,
                });
            }
        },
        error: function () {
            swal({
                type: "error",
                html: "Error data occured.",
            });
        },
    });
}

function formatRibuan(angka) {
    if (typeof angka == "number") {
        angka = angka.toString();
    }
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    console.log("rupiah", rupiah);
    return rupiah;
}

window.postalCode = {
    province: "",
    city: "",
    district: "",
    village: "",
};

function initPostalCode() {
    getProvince();
}

function getProvince() {
    if ($("select#province").val() == null) {
        $("select#city").empty();
        $("select#district").empty();
        $("select#village").empty();
        $("select#postalcode").empty();
    }

    $.get("/api/postalcodes/province").done((data) => {
        console.log(data);
        $("select#province").append(`<option value="">--Pilih--</option>`);
        data.result.forEach((e) => {
            $("select#province").append(`<option value="${e}">${e}</option>`);
        });
    });
}

function getCity() {
    $("select#city").empty();
    $("select#district").empty();
    $("select#village").empty();
    $("select#postalcode").empty();
    postalCode.province = $("select#province").val();
    $.post("/api/postalcodes/city", postalCode).done((data) => {
        $("select#city").append(`<option value="">--Pilih--</option>`);
        data.result.forEach((e) => {
            $("select#city").append(`<option value="${e}">${e}</option>`);
        });
    });
}

function getDistrict() {
    $("select#district").empty();
    $("select#village").empty();
    $("select#postalcode").empty();
    postalCode.city = $("select#city").val();
    $.post("/api/postalcodes/district", postalCode).done((data) => {
        $("select#district").append(`<option value="">--Pilih--</option>`);
        data.result.forEach((e) => {
            $("select#district").append(`<option value="${e}">${e}</option>`);
        });
    });
}

function getVillage() {
    $("select#village").empty();
    $("select#postalcode").empty();
    postalCode.district = $("select#district").val();
    $.post("/api/postalcodes/village", postalCode).done((data) => {
        $("select#village").append(`<option value="">--Pilih--</option>`);
        data.result.forEach((e) => {
            $("select#village").append(`<option value="${e}">${e}</option>`);
        });
    });
}

function getPostalCode() {
    $("select#postalcode").empty();
    postalCode.village = $("select#village").val();
    $.post("/api/postalcodes/postalcode", postalCode).done((data) => {
        $("input#postalcode").val(data.result);
    });
}

// Permohonan Kredit Form Exclusive

const calculate = async ($q) => {
    if (Cemes.noEdit == true) {
        return;
    }
    let data = await ajax_get("/api/v2/calculator", $q, { reportError: false });
    if (!data) {
        console.log(data);
        console.log("ERROR");
        return;
    }
    $("input#installment").val($.FormatCurrency(data.installment));
    return data;
};

const changeDownPaymentPercentage = (e) => {
    if (Cemes.noEdit == true) {
        return;
    }
    const $el = $(e);
    const otr_price = $($el.data("otr-price")).val();
    const percentage = $el.val();
    const $target = $($el.data("target"));
    if (percentage == "") {
        return;
    } else if (percentage >= 100) {
        console.log(percentage);
        $el.val(100);
        return;
    }
    if (Cemes.noEdit) {
        ("Cancelled Set Down Payment COunter");
        return;
    }
    let result = setDownPayment({
        otr_price: otr_price,
        percentage: percentage,
    });
    console.log(otr_price, percentage);
    $target.castVal(result);
};

const setDownPayment = ({ otr_price, percentage } = {}) => {
    try {
        let price = $.CleanNumber(otr_price);
        return $.FormatCurrency(Math.ceil((price * percentage) / 100));
    } catch (error) {
        console.log(error);
        return "";
    }
};

const nullData = {
    default_image_url: "{{ asset('assets/images/image_not_available.png') }}",
    price_after_discount: "0",
    slug: "create",
    tahun_pembuatan: "0",
    name: "-",
    showroom: {
        name: "-",
    },
};

const productPreview = async (el, noEdit = false) => {
    let val = $(el).val();
    Cemes.noEdit = noEdit;
    console.log(val);
    if (val == "") {
        let data = nullData;
        renderPreview(data);
        return;
    }
    let url = $(el).data("detail-url") + "/" + val;
    let $target = $("#product_preview");
    $.get(url).done((res) => {
        let data = res.result;
        renderPreview(data, noEdit);
        Cemes.noEdit = false;
    });
    return true;
};

const changeAddb = (el) => {
    let $el = $(el);
    let tenorInput = $($el.data("tenor-input"));
    tenorInput.html(tenorOptionsByADDB($el.val()));
};

const tenorOptionsByADDB = (value) => {
    let result = "<option> -- Pilih Tenor -- </option>";
    if (value == "") {
        return "<option> -- Pilih Tenor -- </option>";
    }
    const options = (month) => {
        return `<option value="${month}">${month} Bulan</option>`;
    };
    let month = 12;
    let maxYear = 5;
    for (let i = 1; i <= maxYear; i++) {
        const element = value;
        result = result + options(month * i - value);
    }
    console.log("Change Tenor Options");
    return result;
};

const renderPreview = (data, noEdit = false) => {
    $("#default_image_url").attr("src", data.default_image_url);
    $("#car_link").attr("href", `/admin/product/${data.slug}`);
    $("#car_preview_name").html(data.name);
    $("#car_preview_tahun_pembuatan").html(data.tahun_pembuatan);
    $("#car_preview_name").html(data.name);
    $("#car_preview_showroom_name").html(data.showroom.name || "");
    $("#car_preview_price_after_discount").html(
        $.FormatCurrency(data.price_after_discount)
    );
    if (noEdit) {
        console.log("NO EDIT");
        return;
    }
    $("#otr_price").val($.FormatCurrency(data.price_after_discount));
    $("#vehicle_year").val(data.tahun_pembuatan);
    console.log("Change Val");
};
