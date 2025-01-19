import tree_product from "./tree_product.js";
import tree_account from "./tree_account.js";
export default {
    mixins: [tree_account, tree_product],
    methods: {
        showtree(table, uri, value = null) {
            let gf = this;
            var id = `treeview_json_${table}`;

            if (gf.type == "Salary" || gf.type == "Advance") {
                var id = `treeview_json_${table}_${gf.type}`;
            }
            console.log("ididididid", id);

            this.axios
                .post(`/${uri}`, {
                    value: value,
                    type: this.type,
                })
                .then((response) => {
                    this.jsonTreeData = response.data.trees;

                    // console.log("almuhib", this.jsonTreeData);
                    if (this.type_of_tree == 0) {
                        // this if tree is in the orignal screen (account,product,store,structure)

                        this.last_nodes = response.data.last_nodes;
                        $(`#${table}_number`).val(response.data.last_nodes + 1);
                    }

                    console.log(`muhiiiiiiiiiiiiii${id}`, id);

                    $(`#${id}`)
                        .jstree({
                            core: {
                                themes: {
                                    responsive: true,
                                },
                                // so that create works
                                check_callback: true,
                                data: this.jsonTreeData,
                            },
                            types: {
                                default: {
                                    icon: "fa fa-folder text-primary",
                                },
                                file: {
                                    icon: "fa fa-file  text-primary",
                                },
                            },
                            checkbox: {
                                three_state: false,
                            },
                            state: {
                                key: "demo2",
                            },
                            search: {
                                case_insensitive: true,
                                show_only_matches: true,
                            },
                            plugins: [
                                "checkbox",
                                "contextmenu",
                                "dnd",
                                "massload",
                                "search",
                                "sort",
                                "state",
                                "types",
                                "unique",
                                "wholerow",
                                "changed",
                                "conditionalselect",
                            ],
                            contextmenu: {
                                items: contextmenu,
                            },
                        })
                        .on("rename_node.jstree", function (e, data) {})
                        .on("changed.jstree", function (e, data) {
                            if (
                                gf.type == "Sale" ||
                                gf.type == "Cash" ||
                                gf.type == "SaleReturn" ||
                                gf.type == "CashReturn"
                            ) {
                                gf.check_state = [];
                                (gf.unit = []), (gf.counts = {});
                                gf.grand_total = 0;
                                gf.remaining = 0;
                                gf.paid = 0;
                                gf.sub_total = 0;
                                gf.total_quantity = 0;
                                gf.To_pay = 0;
                            }

                            console.log("rrrrrrr", table);
                            console.log(
                                "rrrrrrrrr1",
                                gf.type,
                                gf.indexselected
                            );
                            // indexselected == 0 when operation is sale or what is same when start index from 0
                            if (gf.indexselected || gf.indexselected == 0) {
                                $(
                                    `#${gf.type}_${table}_tree${gf.indexselected}`
                                ).val(data.node.text + "   " + data.node.id);
                                $(
                                    `#${gf.type}_${table}_tree_id${gf.indexselected}`
                                ).val(data.node.id);

                                if (uri == "tree_account") {
                                    if (
                                        table == "accounts" &&
                                        gf.type == "Expence"
                                    ) {
                                        //this if type expence_income accounts

                                        // console.log('accounts',gf.indexselected);
                                        gf.expence_income_account_list[
                                            gf.indexselected
                                        ] = data.node.id;
                                    } else {
                                        gf.account[gf.indexselected] =
                                            data.node.id;
                                    }
                                }
                            } else {
                                $(`#${gf.type}_${table}_tree`).val(
                                    data.node.text + "  " + data.node.id
                                );
                                console.log(
                                    "nowwwwwwwwwwwwww",
                                    `#${gf.type}_${table}_tree_id`
                                );
                                $(`#${gf.type}_${table}_tree_id`).val(
                                    data.node.id
                                );

                                if (table == "account") {
                                    gf.account = data.node.id;
                                }
                            }

                            if (table == "expence" && gf.type == "Expence") {
                                gf.expence[gf.indexselected] = data.node.id;
                            }

                            if (
                                table == "structure" &&
                                gf.type == "Structure"
                            ) {
                                gf.structureselected = data.node.id;
                                gf.structureselectedname = data.node.text;
                                gf.get_job(gf.structureselected);
                            }

                            // ----------------------------------------product-----------------------------------------------------------

                            if (table == "account" || table == "accounts") {
                                gf.check_account(data);
                            }
                            if (table == "product") {
                                console.log("no _productm", data.node.id);
                                gf.check_prouct(table, data, gf.counts);
                            }

                            if (table == "productm") {
                                console.log("yes _productm", data.node.id);
                                gf.productm_tree(data);
                            }

                            if (table == "store") {
                                gf.store = data.node.id;

                                if (gf.type == "Sale") {
                                    gf.get_product_for_sale(
                                        data.node.id,
                                        table
                                    );
                                    gf.get_account_for_store();
                                }

                                if (
                                    gf.type == "Purchase" ||
                                    gf.type == "Supply"
                                ) {
                                    gf.get_account_for_store(gf.counts);
                                }
                                if (
                                    gf.type == "SaleReturn" ||
                                    gf.type == "CashReturn"
                                ) {
                                    gf.get_account_for_store(gf.detail);
                                }

                                if (gf.type == "Cash") {
                                    gf.get_product_for_cash(
                                        data.node.id,
                                        table
                                    );
                                    gf.get_account_for_store();
                                }
                                if (gf.type == "Transfer") {
                                    gf.store_one = data.node.id;
                                    gf.fromstore = data.node.text;
                                    gf.fromstore_id = data.node.id;

                                    gf.get_product_for_transfer(
                                        "store",
                                        data.node.id
                                    );
                                }

                                if (gf.type == "Opening") {
                                    gf.store[gf.indexselected] = data.node.id;
                                }

                                if (
                                    gf.type == "Stock" ||
                                    gf.type == "Movement"
                                ) {
                                    gf.storeselected = data.node.id;
                                    gf.storeselectedname = data.node.text;
                                }
                            }

                            if (table == "storem") {
                                gf.check_storem(data);
                            }

                            if (table == "intostore") {
                                if (gf.type == "Transfer") {
                                    gf.intostore = data.node.text;
                                    gf.intostore_id = data.node.id;
                                }
                            }
                        });
                });
        },

        detect_index(index) {
            this.indexselected = index;
        },

        get_job(id) {
            axios.post(`/staff/get_job/${id}`).then((response) => {
                var arrayLength = response.data.jobs.length;
                var html = "";

                for (var i = 0; i < arrayLength; i++) {
                    console.log("muhib_job", response.data.jobs[i].text);

                    html =
                        html +
                        `<option data-period-${id}= ${response.data.jobs[i].id}   value= ${response.data.jobs[i].id} >${response.data.jobs[i].text}</option>`;
                }
                $(`#select_structure`).html(html);
            });
        },
        // e1f6c764
        addnode() {
            let currentObj = this;
            const config = {
                headers: {
                    "content-type": "multipart/form-data",
                },
            };
            // form data

            console.log("counts", this.counts);
            let formData = new FormData();
            formData.append(
                `${localStorage.getItem("table")}_id`,
                $(`#${localStorage.getItem("table")}_number`).val()
            );
            formData.append("text", this.text);
            // formData.append(`${localStorage.getItem('table')}_name_en`, this.store_name_en);
            formData.append("parent", $("#parent").val());
            // formData.append("account", this.account);
            formData.append("rank", $("#rank").val());
            formData.append("unit", this.unit);
            formData.append("purchase_price", this.purchase_price);
            formData.append("status", this.status);
            // formData.append("status", this.status);

            console.log("eeeeeeeeeeeeeee", this.status);

            if (localStorage.getItem("table") == "product") {
                // formData.append("count", this.counts);
                // formData.append("unit", this.unit);
                // formData.append('purchase_price', this.purchase_price);

                for (var i = 0; i <= this.counts.length; i++) {
                    if (i != this.counts.length) {
                        formData.append("count[]", this.counts[i]);
                    }

                    if (this.purchase_price_for_retail_unit[i] === undefined) {
                        formData.append(
                            "purchase_price_for_retail_unit[]",
                            null
                        );
                    } else {
                        formData.append(
                            "purchase_price_for_retail_unit[]",
                            this.purchase_price_for_retail_unit[i]
                        );
                    }
                    if (this.hash_rate[i] === undefined) {
                        formData.append("hash_rate[]", null);
                    } else {
                        formData.append("hash_rate[]", this.hash_rate[i]);
                    }

                    if (this.retail_unit[i] === undefined) {
                        formData.append("retail_unit[]", null);
                    } else {
                        formData.append("retail_unit[]", this.retail_unit[i]);
                    }

                    // formData.append('purchase_price_for_retail_unit[]', this.purchase_price_for_retail_unit[i]);
                    // formData.append('hash_rate[]', this.hash_rate[i]);
                    // formData.append('retail_unit[]', this.retail_unit[i]);
                }

                formData.append("product_minimum", this.product_minimum);
            }

            axios
                .post(
                    `/store_${localStorage.getItem("table")}`,
                    formData,
                    config
                )
                .then(function (response) {
                    console.log("dfdf", response);
                    // currentObj.success = response.data.success;
                    // currentObj.filename = "";

                    toastMessage("تم الاضافه بنجاح");
                })
                .catch((error) => {
                    // message = {
                    //     error_text:error.response.data.error.text,
                    //     error_hash_rate:error.response.data.error.text,
                    //     error_purchase_price:error.response.data.error.text,
                    // }
                    // return message;
                    // this.error_text = error.response.data.error.text;
                    // this.error_hash_rate = error.response.data.error.hash_rate;
                    // this.error_purchase_price =
                    //     error.response.data.error.purchase_price;
                });
        },
        addnode_account() {
            let currentObj = this;
            const config = {
                headers: {
                    "content-type": "multipart/form-data",
                },
            };
            // form data

            console.log("counts", this.counts);
            let formData = new FormData();
            formData.append(
                `${localStorage.getItem("table")}_id`,
                $(`#${localStorage.getItem("table")}_number`).val()
            );

            formData.append("text", this.text);
            // formData.append(`${localStorage.getItem('table')}_name_en`, this.store_name_en);
            formData.append("parent", $("#parent").val());
            // formData.append("account", this.account);
            formData.append("rank", $("#rank").val());
            formData.append("status_account", this.status_account);
            formData.append("account_type", this.account_type);
            formData.append(
                "account_type_debit_credit",
                this.account_type_debit_credit
            );
            formData.append("final_account", this.final_account);

            // formData.append("purchase_price", this.purchase_price);

            axios
                .post(
                    `store_${localStorage.getItem("table")}`,
                    formData,
                    config
                )
                .then(function (response) {
                    console.log(response);
                    currentObj.success = response.data.success;
                    currentObj.filename = "";

                    toastMessage("تم الاضافه بنجاح");
                })
                .catch((error) => {
                    console.error(error);

                    this.error_text = error.response.data.error.text;
                    this.error_hash_rate = error.response.data.error.hash_rate;
                    this.error_purchase_price =
                        error.response.data.error.purchase_price;
                });
        },
    },
};
