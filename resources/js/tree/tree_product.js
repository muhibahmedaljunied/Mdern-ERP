export default {
    methods: {
        check_prouct(table, data, count = null) {
            // this.productm = []; //this for empty productm array when change from product into another by clicking tree
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

            if (
                this.type == "OpeningInventory"
            ) {
                this.product_tree(data,'/opening/newopening'); //this for get units of product
            }

            if (
                this.type == "Purchase"
            ) {
                this.product_tree_for_purchase_supply(data,'/purchase/newpurchase'); //this for get units of product
            }


            if (

                this.type == "Supply"

            ) {
                this.product_tree_for_purchase_supply(data,'/supply/newsupply'); //this for get units of product
            }

            if (this.type == "Transfer") {
                this.get_product(table, `/get_product/${data.node.id}`);
            }

            if (this.type == "Price") {
                this.product_tree_for_price(data, count); //this for get units of product
            }

            if (this.type == "Cash") {
                this.get_product(table, `/cash/newcash/${data.node.id}`);
            }

            if (this.type == "Sale") {
                this.get_product(table, `/sale/newsale/${data.node.id}`);
            }

            // if (this.type == "Transfer") {
            //     this.product_one = data.node.id;
            //     this.get_product_for_transfer("product", data.node.id);
            // }

            // if (this.type == "Transfer") {
            //     gf.store_one = data.node.id;
            //     gf.fromstore = data.node.text;
            //     gf.fromstore_id = data.node.id;

            //     gf.get_product_for_transfer("store", data.node.id);
            // }
        },
        // productm_tree(data) {
        //     this.productm[this.indexselected] = data.node.id;
        //     console.log("data.node.id", data.node.id);
        //     axios.post(`/get_unit/${data.node.id}`).then((response) => {
        //         this.units = response.data.units;

        //         // this.units = response.data.units;
        //         console.log("almuhib", this.units);
        //         var arrayLength = response.data.units.length;
        //         var html = "";

        //         for (var i = 0; i < arrayLength; i++) {
        //             html =
        //                 html +
        //                 `<option  value=[${this.units[i].unit_id},${this.units[i].rate}]>${this.units[i].name}</option>`;
        //         }
        //         $(`#select_unit${this.indexselected}`).html(html);

        //         $(`#${this.type}_productm_tree${this.indexselected}`).val(
        //             data.node.text
        //         );
        //     });
        // },
        product_tree(data,uri) {
            this.product = data.node.id;
            axios.post(`${uri}/${data.node.id}`,{
                type: 'product',
            }).then((response) => {

                this.statuses = response.data.statuses;
                // this.store_products = data.store_products;
                this.store_products = response.data.store_products;

                console.log("almuhibesssssssssssss", response.data.products);
                for (
                    let index = 0;
                    index < this.store_products.length;
                    index++
                ) {
                    this.productm[index] = data.node.id;
                    this.store_product_id[index] =
                        this.store_products[index].store_product_id;
                }
            });
        },
        product_tree_for_purchase_supply(data,uri) {
            this.product = data.node.id;
            axios.post(`${uri}/${data.node.id}`,{
                type: 'product',
            }).then((response) => {
                this.store_products = response.data.store_products;
                this.products = response.data.products;
                this.suppliers = response.data.suppliers;
                this.stores = response.data.stores;
                this.statuses = response.data.statuses;
                this.treasuries = response.data.treasuries;

                for (
                    let index = 0;
                    index < this.store_products.length;
                    index++
                ) {
                    this.productm[index] = data.node.id;
                    this.store_product_id[index] =
                        this.store_products[index].store_product_id;
                }


            });
        },
        product_tree_for_transfer(data) {
            this.product = data.node.id;
            axios.post(`/get_product/${data.node.id}`).then((response) => {
                this.count = responce.data.products.length;
                this.store_products = response.data.products;


                for (
                    let index = 0;
                    index < this.store_products.length;
                    index++
                ) {
                    this.productm[index] = data.node.id;
                    this.store_product_id[index] =
                        this.store_products[index].store_product_id;
                }
            });
        },

        product_tree_for_price(data, count = null) {
            this.product = data.node.id;
            axios
                .post(`/get_product_price/${data.node.id}`)
                .then((response) => {
                    this.store_products = response.data.products;

                    for (
                        let index = 0;
                        index < this.store_products.length;
                        index++
                    ) {
                        this.productm[index] = data.node.id;
                        console.log(
                            "productm________almuhibesssssssssssss",
                            this.productm[index]
                        );
                    }
                });
        },
        get_product(table, uri) {
            axios
                .post(`${uri}`, {
                    type: table,
                    operation: "StockQty",
                })
                .then((responce) => {
                    this.count = responce.data.products.length;
                    this.store_products = responce.data.products;
                });
        },
    },
};
