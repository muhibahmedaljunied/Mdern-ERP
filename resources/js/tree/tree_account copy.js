import { forIn } from "lodash";

export default {
    methods: {
        check_storem(data) {
            this.storem[this.indexselected] = data.node.id;
            // console.log('masa',data.node.id,this.storem[this.indexselected]);

            if (
                this.type == "Purchase" ||
                this.type == "Supply" ||
                this.type == "SaleReturn"
                // ||
                // this.type == "OpeningInventory"
            ) {
                this.get_account_for_storem(data.node.id);
            }
        },
        check_account(data) {
            // this.account = data.node.id;

            if (
                this.type == "Sale" ||
                this.type == "SaleReturn" ||
                this.type == "Cash" ||
                this.type == "CashReturn" ||
                this.type == "Purchase" ||
                this.type == "PurchaseReturn" ||
                this.type == "Supply" ||
                this.type == "SupplyReturn" ||
                this.type == "ReceivableBond" ||
                this.type == "PaymentBond" ||
                this.type == "Expence" ||
                this.type == "Advance" ||
                this.type == "OpenningBalance" ||
                this.type == "AccountReport"
            ) {
                // console.log('almuheeb',3);
                this.group_accounts_details(data.node.id);
            }
        },
        get_account_for_store(length) {
            //this called when selected store in top

            axios.post(`/get_account_store/${this.store}`).then((response) => {
                var arrayLength = response.data.accounts.length;

                console.log(response.data.accounts);

                if (arrayLength == 0) {
                    $(`#select_account_${this.type}`).html("");
                    return;
                }

                $(`#select_account_${this.type}`).val(
                    response.data.accounts[0].id
                );

                // -----------------------------------------------------------------------------------
                for (const key in length) {
                    if (length.hasOwnProperty.call(length, key)) {
                        let element = 0;
                        console.log(key, this.type);

                        if (
                            this.type == "Purchase" ||
                            this.type == "Supply"
                            || this.type == "OpeningInventory"
                        ) {
                            element = length[key];
                        }

                        if (this.type == "SaleReturn") {
                            element = key;
                        }

                        if (!response.data.accounts.account_id) {
                            this.get_storem_by_store(
                                element,
                                response.data.accounts
                            );
                        } else {
                            this.get_account_for_storem_by_store(
                                element,
                                response.data.accounts
                            );
                        }
                    }
                }
            });
        },

        get_storem_by_store(index, response_id) {
            //this called for return stores in bottom when selected store in top

            $(`#${this.type}_storem_tree${index}`).val(
                response_id[0].text + "   " + response_id[0].id
            );

            this.storem[index] = this.store;
        },

        get_account_for_storem_by_store(index, response_id) {
            //this called for return accounts of stores in bottom when selected store in top

            $(`#${this.type}_storem_tree${index}`).val(
                response_id[0].text + "   " + response_id[0].id
            );

            this.storem[index] = this.store;
            this.storem_account[index] = response_id[0].id;
        },
        get_account_for_storem(d) {
            // this called when selected store on dedecated rows
            // console.log('almuhib',this.storem[this.indexselected]);

            // alert('yes');

            axios
                .post(`/get_account_store/${this.storem[this.indexselected]}`)
                .then(async (response) => {
                    var arrayLength = response.data.accounts.length;
                    if (arrayLength == 0) {
                        return;
                    }

                    this.storem_account[this.indexselected] =
                        response.data.accounts[0].id;
                });

            console.log(
                "masa",
                this.indexselected,
                this.storem_account[this.indexselected]
            );

            // this.storem_account[this.indexselected] = await uh;
        },

        // gr(h) {
        //     this.storem_account[this.indexselected] = h;
        // },

        group_accounts_details(id) {
            axios
                .post(`/get_group_accounts_details_details/${id}`)
                .then((response) => {
                    var arrayLength = response.data.result_data.length;

                    console.log(
                        "ffffffffffffffffffffff",
                        response.data.group_type
                    );
                    if (response.data.result_data == 0) {
                        arrayLength = 0;
                    }
                    console.log("dfffffff", this.type);
                    var html = "";
                    if (arrayLength == 0) {
                        $(`#select_account_${this.type}`).html("");

                        if (this.indexselected) {
                            $(
                                `#select_account_${this.type}_group_${this.indexselected}`
                            ).html("");
                        } else {
                            $(`#select_account_${this.type}_group`).html("");
                        }

                        return;
                    }
                    for (var i = 0; i < arrayLength; i++) {
                        html =
                            html +
                            `<option 
                                            value=${response.data.result_data[i].id}>${response.data.result_data[i].name}
                                    </option>`;

                        if (response.data.group_type == "supplier") {
                            this.supplier[0] = response.data.result_data[i].id;
                            this.supplier[1] =
                                response.data.result_data[i].name;
                        }

                        if (response.data.group_type == "customer") {
                            this.customer[0] = response.data.result_data[i].id;
                            this.customer[1] =
                                response.data.result_data[i].name;
                        }

                        if (response.data.group_type == "treasury") {
                            this.treasury[0] = response.data.result_data[i].id;
                            this.treasury[1] =
                                response.data.result_data[i].name;
                        }

                        if (response.data.group_type == "bank") {
                            this.bank[0] = response.data.result_data[i].id;
                            this.bank[1] = response.data.result_data[i].name;
                        }
                    }
                    // console.log('qw',html);

                    if (this.indexselected) {
                        $(
                            `#select_account_${this.type}_group_${this.indexselected}`
                        ).html(html);
                    } else {
                        $(`#select_account_${this.type}_group`).html(html);
                    }
                });
        },
    },
};
