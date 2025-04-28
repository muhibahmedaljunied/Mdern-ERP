import calculate from "./calculate_operation.js";
export default {
    mixins: [calculate],
    data() {
        return {
            value_list: {
                type: Object,
                default: null,
            },
            show: "",
            date: new Date().toISOString().substr(0, 10),
            dateselected: new Date().toISOString().substr(0, 10),
            expiry_date: new Date().toISOString().substr(0, 10),
            purchase_id: [],

            discount: [],
            store_product_id: [],
            cost: [],
            bank: [],
            product: [],
            typeselected: [],
            currency: [],
            qty: [],
            debit: [],
            credit: [],
            unit: [],
            desc: [],
            store: [],
            status: [],
            counts: {},
            total: [],
            customer: [],
            supplier: [],
            check_state: [],
            return_qty: [],
            price: [],
            tax: [],
            treasury: [],
            storem_account: [],
            productm: [],
            intostore: [],
            intostore_id: [],
            account_in_list: [],
            count: 1,
            row_counter: "",
            first_row: "",
            table: "",
            type: "",
            type_refresh: "",
            note: "",
            detail: "",
            total_quantity: 0,
            treasuries: "",
            banks: "",
            products: "",
            store_products: "",
            stores: "",
            statuses: "",
            stores: "",
            statuses: "",
            units: "",
            opening: "",
            availabe_qty: [],
            word_search: "",

            suppliers: "",
            customers: "",
            seen: false,
            id: "",

            operation_status: 1,
            grand_total: 0,
            sub_total: 0,
            To_pay: 0,
            total_tax: 0,
            storem: [],
            unit_price: [],
            // unit_price: [],
            unit: [],
            paid: 0,
            remaining: 0,
            Way_to_pay_selected: 1,
        };
    },
    watch: {
        Way_to_pay_selected(newVal, oldVal) {
            console.log("xxxx");
            $(`#treeview_json_account`).jstree(true).destroy();

            this.showtree("account", "tree_account", this.Way_to_pay_selected);

            console.log("alkhm", newVal, oldVal);
        },
        count(newVal, oldVal) {
            this.day_value;
        },
    },

    methods: {
        set_unit_price(index) {
            console.log('yessssssss',this.unit);
            this.unit_price[index] = this.unit[index][2];
        },
        addComponent(index) {
            this.count += 1;
            this.counts[index] = this.count;
            // this.calculate();
        },
        disComponent(index) {
            if (index != 1) {
                this.count -= 1;
                this.$delete(this.counts, index - 1);
            }
            // this.calculate();
        },

        init() {
            this.grand_total = 0;
            this.sub_total = 0;
            this.total_tax = 0;
            this.total_quantity = 0;
            this.remaining = 0;
            this.paid = 0;
            this.To_pay = 0;

            if (
                this.type == "Purchase" ||
                this.type == "Supply" ||
                this.type == "OpeningInventory"
            ) {
                // var count = this.count;
                // console.log('init_init_init_init',this.store_products.length);
                this.count = this.store_products.length;
            } else {
                this.count = this.detail.length;
            }

            return this.count;
        },

        take_discount() {
            if (this.discounts != 0) {
                this.sub_total =
                    (parseInt(this.discounts) * this.sub_total) / 100;
            }
        },

        credit_func() {
            if (this.paid == "") {
                this.paid = 0;
            }
            this.remaining = parseInt(this.grand_total) - parseInt(this.paid);
        },

        check_all_return() {
            for (let index = 0; index < this.detail.length; index++) {
                if (this.check_state_all == true) {
                    this.check_state[index] = true;
                } else {
                    this.check_state[index] = false;
                }

                this.detail.forEach((element) => {
                    this.check_one(element, index);
                });
            }
        },

        handle_top() {
            // if (
            //     this.type != "Purchase" &&
            //     this.type != "Supply" &&
            //     this.type != "OpeningInventory"
            // ) {
                // this.set_values();
                // this.set_price();
            // }

              // if (
            //     this.type != "Purchase" &&
            //     this.type != "Supply" &&
            //     this.type != "OpeningInventory"
            // ) {
                // this.set_values();
                // this.set_price();
            // }



            if (this.calculate_total_with_check() == 0) {
                return 0;
            }
            return 1;
        },
        handle_down() {
            this.calculate_qty();
            this.calculate_tax();
            this.calculate_grand_total();
            this.credit_func();
            this.calculate_remaining();
        },

        set_price() {
            console.log(this.unit_price[this.row_counter]);

            if (!this.unit_price[this.row_counter]) {
                if (this.detail[this.row_counter].price) {
                    this.unit_price[this.row_counter] =
                        this.detail[this.row_counter].price;
                }
            }
        },
    },
};
