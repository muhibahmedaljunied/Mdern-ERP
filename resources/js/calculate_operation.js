export default {
    methods: {
        calculate_qty() {
            if (this.qty[this.row_counter]) {
                this.total_quantity =
                    parseInt(this.qty[this.row_counter]) +
                    parseInt(this.total_quantity);
            } else {
                this.total_quantity =
                    parseInt(0) + parseInt(this.total_quantity);
            }

            console.log("muhibllllllllll");
        },

        calculate_remaining() {
            if (this.Way_to_pay_selected == 2) {
                this.remaining = this.grand_total;
            } else {
                this.remaining = 0;
            }
        },

        calculate() {
            var count = this.init();
            console.log('purchase_after_update',count,this.first_row);

            for (let index = this.first_row; index <= count; index++) {
                this.row_counter = index;
                if (
                    this.type == "Purchase" ||
                    this.type == "PurchaseReturn" ||
                    this.type == "Sale" ||
                    this.type == "SaleReturn" ||
                    this.type == "Cash" ||
                    this.type == "CashReturn" ||
                    this.type == "Supply" ||
                    this.type == "Supplyeturn" ||
                    this.type == "OpeningInventory"
                ) {

                    this.check_state[this.row_counter] = true;

                }

                if (this.check_state[this.row_counter] == true) {
                    if (this.handle_top() == 0) {
                        return 0;
                    }

                    if (this.operation_status == 0) {
                        this.operation_status = 1;
                    } else {
                        this.handle_down();
                    }
                }
            }
        },

        calculate_total(i) {
            console.log("dddddd2", i);

            if (this.check_state[i] != true) {
                if (this.check_data(i) != 0) {
                    if (this.unit_price[i]) {
                        this.total[i] =
                            this.unit_price[i] * this.unit[i][1] * this.qty[i];
                    }
                }
            }
        },

        calculate_total_with_check() {
            // console.log(
            //     "yeeeeeeeeeeeeeeeeeez",

            //     this.row_counter,
            //     this.check_state[this.row_counter],
            //     this.unit,
            //     this.unit[this.row_counter],
            //     this.qty[this.row_counter],
            //     this.unit_price[this.row_counter],

            //     // this.unit[0][0],
            //     // this.qty[0],
            //     // this.unit_price[0],

            //     this.row_counter
            // );
            if (
                this.unit[this.row_counter] &&
                this.qty[this.row_counter] &&
                this.unit_price[this.row_counter]
            ) {
                this.check_check_data();
            } else {
                this.total[this.row_counter] = 0;
                this.operation_status = 0;
            }
        },

        check_check_data() {
            var unit = 0;

            if (this.check_data(this.row_counter) != 0) {
                unit = this.unit[this.row_counter];
                if (typeof this.unit[this.row_counter] == "string") {
                    unit = JSON.parse(this.unit[this.row_counter]);
                }
                if (
                    this.qty[this.row_counter] <= 0 ||
                    this.unit_price[this.row_counter] <= 0
                ) {
                    this.total[this.row_counter] = 0;
                    this.operation_status = 0;
                } else {
                    this.operation_status = 1;
                    this.total[this.row_counter] =
                        this.unit_price[this.row_counter] *
                        this.qty[this.row_counter] ;
                }

                return 1;
            }

            return 0;
        },
        calculate_grand_total() {
            if (this.total[this.row_counter]) {
                this.grand_total =
                    parseInt(this.total[this.row_counter]) +
                    parseInt(this.grand_total);
            } else {
                this.grand_total = parseInt(0) + parseInt(this.grand_total);
            }

            this.sub_total =
                parseInt(this.grand_total) - parseInt(this.total_tax);

            this.To_pay = this.grand_total;
        },

        calculate_tax() {
            if (this.tax[this.row_counter]) {
                this.total_tax =
                    parseInt(this.tax[this.row_counter]) +
                    parseInt(this.total_tax);
            } else {
                this.total_tax = parseInt(0) + parseInt(this.total_tax);
            }
        },
    },
};
