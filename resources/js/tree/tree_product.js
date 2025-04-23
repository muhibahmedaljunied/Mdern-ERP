export default {
    methods: {
        check_prouct(table, data, count = null) {
            console.log(
                "check_prouctcheck_prouctcheck_prouct",
                table,
                data,
                count
            );
            if (this.type == "Stock" || this.type == "Movement") {
                this.productselected = data.node.id;
                this.productselectedname = data.node.text;
            }
            if (this.type == "OpeningInventory") {
                // this.product[this.indexselected] = data.node.id;
                this.product_tree_for_opening_inventury(data, count); //this for get units of product
            }

            if (this.type == "Purchase" || this.type == "Supply") {
                this.product_tree(data, count); //this for get units of product
            }
            if (this.type == "Price") {
                this.product_tree_for_price(data, count); //this for get units of product
            }

            if (this.type == "Cash") {
                this.get_product_for_cash(data.node.id, table);
            }

            if (this.type == "Sale") {
                this.get_product_for_sale(data.node.id, table);
            }

            if (this.type == "Transfer") {
                this.product_one = data.node.id;
                this.get_product_for_transfer("product", data.node.id);
            }

            if (this.type == "Transfer") {
                gf.store_one = data.node.id;
                gf.fromstore = data.node.text;
                gf.fromstore_id = data.node.id;

                gf.get_product_for_transfer("store", data.node.id);
            }
        },
        productm_tree(data) {
            this.productm[this.indexselected] = data.node.id;
            console.log("data.node.id", data.node.id);
            axios.post(`/get_unit/${data.node.id}`).then((response) => {
                this.units = response.data.units;

                // this.units = response.data.units;
                console.log("almuhib", this.units);
                var arrayLength = response.data.units.length;
                var html = "";

                for (var i = 0; i < arrayLength; i++) {
                    html =
                        html +
                        `<option  value=[${this.units[i].unit_id},${this.units[i].rate}]>${this.units[i].name}</option>`;
                }
                $(`#select_unit${this.indexselected}`).html(html);

                $(`#${this.type}_productm_tree${this.indexselected}`).val(
                    data.node.text
                );
            });
        },
        product_tree(data, count = null) {
            this.product = data.node.id;
            axios.post(`/get_unit/${data.node.id}`).then((response) => {
                this.store_products = response.data.products;
                console.log("almuhibesssssssssssss", response.data.products);
                for (const key in count) {
<<<<<<< HEAD
                   
                    // $(`#${this.type}_productm_tree${ds}`).val(data.node.text);
                    this.productm[key] = data.node.id;
                    console.log("almuhib", this.productm,count[key],count);
                }
            });
        },
        product_tree_for_opening_inventury(data, count = null) {
            this.product = data.node.id;
            axios.post(`/get_unit/${data.node.id}`).then((response) => {
                this.store_products = response.data.products;
                console.log("almuhibesssssssssssss", response.data.products);
                for (const key in count) {
=======
>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5
                    console.log("almuhib", count, count[key]);
                    // $(`#${this.type}_productm_tree${ds}`).val(data.node.text);
                    this.productm[count[key]] = data.node.id;
                }
            });
        },
        product_tree_for_price(data, count = null) {
            this.product = data.node.id;
            axios.post(`/get_product_price/${data.node.id}`).then((response) => {
                this.store_products = response.data.products;
                console.log("almuhibesssssssssssss", response.data.products);
                for (const key in count) {
                    console.log("almuhib", count, count[key]);
                    // $(`#${this.type}_productm_tree${ds}`).val(data.node.text);
                    this.productm[count[key]] = data.node.id;
                }
            });
        },

        get_product_for_sale(id, table) {
            axios
                .post(`/sale/newsale/${id}`, {
                    type: table,
                    operation: "StockQty",
                })
                .then((responce) => {
                    responce.data.products.data.forEach((element) => {
                        this.unit_price.push(element.cost);
                    });

                    this.detail = responce.data.products.data;
                    // console.log(responce.data);
                    this.units = responce.data.units;
                });
        },

        get_product_for_cash(id, table) {
            axios
                .post(`/cash/newcash/${id}`, {
                    type: table,
                    operation: "StockQty",
                })
                .then((responce) => {
                    responce.data.products.data.forEach((element) => {
                        // ----------

                        this.unit_price.push(element.cost);
                    });

                    this.detail = responce.data.products.data;
                    this.units = responce.data.units;
                });
        },

        get_product_for_transfer(type, id) {
            let uri = `/get_product`;
            axios
                .post(uri, {
                    id: id,
                    type_search: type,
                    type: "Transfer",
                    operation: "StockQty",
                })
                .then((responce) => {
                    this.detail = responce.data.products;
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },
    },
};
