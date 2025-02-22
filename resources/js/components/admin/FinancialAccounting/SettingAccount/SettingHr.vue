<template>
    <div class="container-fluid">



        <div class="row row-sm">

            <div class="col-xl-12">

                <div class="card">





                    <div class="card-header">
                        <span class="h2"> الموارد البشريه</span>
                        <div style="display: flex;float: left; margin: 5px">


                            <button @click="exports_excel()">

                                <i class="fa-solid fa-file-export " style="font-size: 24px; color: #63E6BE;"></i>
                            </button>

                            <button @click="imports_excel()">

                                <i class="fa-solid fa-file-import " style="font-size: 24px; color: #B197FC;"></i>
                            </button>

                            <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="true" placeholder="بحث" v-model="word_search"
                                @input="get_search()" />
                        </div>
                    </div>


                    <div class="card-body">






                        <!-- 

                        <a @click="exports_excel()">

                            <img src="/assets/img/export.png" alt="" style="width: 2%;"></a>



                        <a @click="imports_excel()">

                            <img src="/assets/img/import.png" alt="" style="width: 2%;"></a>


 -->




                        <template>

                            <div v-for="(group_types, index) in list_data">

                                <div v-for="(accounts, index) in group_types.group" :key="index"
                                    v-if="accounts.status == 1" class="row">




                                    <fieldset class="border rounded-3 p-3">
                                        <legend class="float-none w-auto px-3"> {{ group_types.name }}</legend>



                                        <div class="modal fade" :id="'exampleModal' + accounts.code" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                            <div class="modal-dialog" role="document">

                                                <div class="modal-content">

                                                    <div class="modal-header">



                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">

                                                            <span aria-hidden="true">&times;</span>

                                                        </button>

                                                    </div>

                                                    <div class="modal-body">



                                                        <div class="well" :id="'treeview_json_' + accounts.code">

                                                        </div>



                                                    </div>



                                                </div>

                                            </div>

                                        </div>



                                        <div class="modal fade" :id="'exampleModal' + accounts.code + group_types.type"
                                            tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                            aria-hidden="true">

                                            <div class="modal-dialog" role="document">

                                                <div class="modal-content">

                                                    <div class="modal-header">



                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">

                                                            <span aria-hidden="true">&times;</span>

                                                        </button>

                                                    </div>

                                                    <div class="modal-body">



                                                        <div class="well"
                                                            :id="'treeview_json_' + accounts.code + group_types.type">

                                                        </div>



                                                    </div>



                                                </div>

                                            </div>

                                        </div>



                                        <div class="row" v-for="(accounts2, index) in accounts.group_account"
                                            :key="index">



                                            <div class="col-md-4">







                                                <div class="custom-search" v-if="accounts2.account_id">





                                                    <input style="background-color: beige;"
                                                        :id="'Structure_' + accounts.code + '_tree'" type="text"
                                                        readonly class="custom-search-input"
                                                        :value="accounts2.account_id + accounts.name">





                                                    <input style="background-color: beige;"
                                                        :id="'Structure_' + accounts.code + '_tree_id'" type="hidden"
                                                        readonly class="custom-search-input"
                                                        :value="accounts2.account_id">

                                                    <input style="background-color: beige;"
                                                        :id="'Structure_' + accounts.code + '_tree_hraccount_id'"
                                                        type="hidden" readonly class="custom-search-input"
                                                        :value="accounts2.id">

                                                    <button class="custom-search-botton" type="button"
                                                        data-toggle="modal"
                                                        :data-target="'#exampleModal' + accounts.code"> <i
                                                            class="fa fa-plus-circle"></i></button>

                                                </div>

                                                <div class="custom-search" v-else>

                                                    <input style="background-color: beige;"
                                                        :id="'Structure_' + accounts.code + '_tree'" type="text"
                                                        readonly class="custom-search-input">

                                                    <input style="background-color: beige;"
                                                        :id="'Structure_' + accounts.code + '_tree_id'" type="hidden"
                                                        readonly class="custom-search-input">

                                                    <input style="background-color: beige;"
                                                        :id="'Structure_' + accounts.code + '_tree_hraccount_id'"
                                                        type="hidden" readonly class="custom-search-input"
                                                        :value="accounts.id">



                                                    <button class="custom-search-botton" type="button"
                                                        data-toggle="modal"
                                                        :data-target="'#exampleModal' + accounts.code"> <i
                                                            class="fa fa-plus-circle"></i></button>

                                                </div>

                                            </div>







                                            <div class="col-md-2">

                                                <label for="inputAddress">الحساب المقابل</label>

                                            </div>

                                            <div class="col-md-4"
                                                v-for="(accounts3, index) in accounts2.group_account_detail"
                                                :key="index">


                                                <div class="custom-search" v-if="accounts3.id">

                                                    <input style="background-color: beige;"
                                                        :id="'Structure_' + accounts.code + group_types.type + '_tree'"
                                                        type="text" readonly class="custom-search-input"
                                                        :value="accounts3.account.id + accounts3.account.text">

                                                    <input style="background-color: beige;"
                                                        :id="'Structure_' + accounts.code + group_types.type + '_tree_id'"
                                                        type="hidden" readonly class="custom-search-input"
                                                        :value="accounts3.account.id">

                                                    <input style="background-color: beige;"
                                                        :id="'Structure_' + accounts.code + group_types.type + '_tree_hraccount_id'"
                                                        type="hidden" readonly class="custom-search-input"
                                                        :value="accounts.id">

                                                    <button class="custom-search-botton" type="button"
                                                        data-toggle="modal"
                                                        :data-target="'#exampleModal' + accounts.code + group_types.type">

                                                        <i class="fa fa-plus-circle"></i></button>

                                                </div>



                                            </div>
                                            <div v-if="!accounts2.group_account_detail.length" class="col-md-4">

                                                <div class="custom-search">

                                                    <input style="background-color: beige;"
                                                        :id="'Structure_' + accounts.code + group_types.type + '_tree'"
                                                        type="text" readonly class="custom-search-input">

                                                    <input style="background-color: beige;"
                                                        :id="'Structure_' + accounts.code + group_types.type + '_tree_id'"
                                                        type="hidden" readonly class="custom-search-input">

                                                    <input style="background-color: beige;"
                                                        :id="'Structure_' + accounts.code + group_types.type + '_tree_hraccount_id'"
                                                        type="hidden" readonly class="custom-search-input"
                                                        :value="accounts.id">



                                                    <button class="custom-search-botton" type="button"
                                                        data-toggle="modal"
                                                        :data-target="'#exampleModal' + accounts.code + group_types.type">

                                                        <i class="fa fa-plus-circle"></i></button>

                                                </div>
                                            </div>







                                        </div>

                                    </fieldset>



                                </div>









                            </div>
                        </template>


                        <button type="button" class="btn btn-primary" @click="submitForm()">حفظ
                        </button>





                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import tree from '../../../../tree/tree.js';
import operation from '../../../../operation1.js';
export default {

    mixins: [tree, operation],
    data() {
        return {
            list_data: '',
            account: [],
            code: [],
            type_account: [],
            count_accounts: '',
            group_type: '',




        };
    },
    mounted() {

        this.counts[0] = 1;
        this.type_of_tree = 1;
        this.type = 'Structure';
        this.list();



    },

    methods: {


        add_new_account() {

            this.axios
                .post(`/store_account_setting`, {
                    count: this.counts,
                    type: this.type,
                    name: this.account,
                    code: this.code,
                    type_account: this.type_account,

                })
                .then((response) => {
                    console.log(response);
                    toastMessage("تم الاضافه بنجاح");
                    // this.$router.go(0);
                });
        },
        submitForm() {

            let currentObj = this;
            const config = {
                headers: {
                    "content-type": "multipart/form-data",
                },
            };
            // form data
            let formData = new FormData();

            for (let index = 0; index < this.count_accounts; index++) {

                this.list_data[index].group.forEach(element => {


                    formData.append(`staff_${element.code}_account_id`,
                        $(`#Structure_${element.code}_tree_id`).val()

                    );
                    formData.append(`staff_${element.code}_account_hraccount_id`,
                        $(`#Structure_${element.code}_tree_hraccount_id`).val(),

                    );
                    formData.append(`staff_${element.code}_account_name`, [
                        $(`#Structure_${element.code}_tree`).val(),

                    ]);

                    // ---------------------------------------------------------------------------------------------------


                    formData.append(`staff_${element.code + this.list_data[index].type}_second_account_id`,
                        $(`#Structure_${element.code + this.list_data[index].type}_tree_id`).val()
                    );
                    formData.append(`staff_${element.code + this.list_data[index].type}_second_account_hraccount_id`,
                        $(`#Structure_${element.code + this.list_data[index].type}_tree_hraccount_id`).val()

                    );
                    formData.append(`staff_${element.code + this.list_data[index].type}_second_account_name`,
                        $(`#Structure_${element.code + this.list_data[index].type}_tree`).val()

                    );






                });



            }

            // send upload request
            this.axios
                .post("/store_staff_account_setting", formData, config)
                .then(function (response) {
                    console.log("hhhhhhhhhhhhhhhhhhhhhhh");
                    console.log(response);
                    currentObj.success = response.data.success;
                    currentObj.filename = "";

                    // e.preventDefault();
                    toastMessage("تم الاضافه بنجاح");
                })
                .catch(function (error) {
                    currentObj.output = error;
                });

            // this.$router.go(0);
        },

        list() {

            this.axios
                .post(`/get_staff_account_setting`)
                .then(({ data }) => {

                    this.list_data = data.accounts;
                    this.count_accounts = data.count_account;
                    this.group_type = data.group_type;



                    for (let index = 0; index < this.count_accounts; index++) {



                        this.list_data[index].group.forEach(element => {

                            this.showtree(element.code, 'tree_account');
                            this.showtree(element.code + this.list_data[index].type, 'tree_account');

                        });




                    }

                });




        },

        exports_excel() {

            axios
                .post(`/export_hr_setting`)
                .then(function (response) {

                    // console.log(1);
                })
                .catch(error => {

                });
        },
        imports_excel() {

            axios
                .post(`/import_hr_setting`)
                .then(function (response) {

                    // console.log(1);
                })
                .catch(error => {

                });
        },



    },
};
//
</script>