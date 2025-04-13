<template>
    <div class="container-fluid">
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h2>ترميز البنوك</h2>
                    </div>
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form method="post" enctype="multipart/form-data">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered text-right m-t-30" style="
                                                                width: 100%;
                                                                font-size: x-small;
                                                            ">
                                                            <thead>
                                                                <tr>
                                                                    <!-- <th>
                                                                        نوع
                                                                        التصنيف
                                                                    </th> -->
                                                                    <th >الرقم التسلسلي</th>
                                                                    <th>
                                                                        التصنيف
                                                                    </th>
                                                                    <th>
                                                                        البنك
                                                                    </th>

                                                                    <!-- <th> الرمز </th> -->

                                                                    <!-- <th>رقم الحساب </th> -->

                                                                    <th>
                                                                        اضافه
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr v-for="index in count" :key="index">

                                                                    <td>
                                                                        {{ index+1 }}
                                                                    </td>
                                                                    <td>
                                                                        <select style="
                                                                                background-color: beige;
                                                                            " name="forma_pago" class="form-control"
                                                                            v-model="group[
                                                                                index
                                                                                ]
                                                                                " 
                                                                                >
                                                                            <!-- <option v-bind:value="1">الكل</option> -->
                                                                            <option v-for="gg in groups"
                                                                                v-bind:value="gg.group_id
                                                                                    ">
                                                                                {{
                                                                                    gg.group_name
                                                                                }}
                                                                            </option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select style="
                                                                                background-color: beige;
                                                                            " name="forma_pago" class="form-control"
                                                                            v-model="bank[
                                                                                index
                                                                                ]
                                                                                " 
                                                                                >
                                                                            <!-- <option v-bind:value="1">الكل</option> -->
                                                                            <option v-for="bank in banks"
                                                                                v-bind:value="bank.id
                                                                                    ">
                                                                                {{
                                                                                    bank.name
                                                                                }}
                                                                            </option>
                                                                        </select>
                                                                    </td>




                                                                    <td v-if="
                                                                        index ==
                                                                        1
                                                                    ">
                                                                        <a class="tn btn-info btn-sm waves-effect btn-agregar"
                                                                            v-on:click="
                                                                                addComponent(
                                                                                    count
                                                                                )
                                                                                ">
                                                                            <i class="fa fa-plus-circle"></i></a>

                                                                        <a class="tn btn-info btn-sm waves-effect btn-agregar"
                                                                            v-on:click="
                                                                                disComponent(
                                                                                    count
                                                                                )
                                                                                ">
                                                                            <i class="fa fa-minus-circle"></i></a>
                                                                    </td>

                                                                    <div class="modal fade" :id="'exampleModalMark'"
                                                                        tabindex="-1" role="dialog"
                                                                        aria-labelledby="exampleModalLabel"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close"
                                                                                        data-dismiss="modal"
                                                                                        aria-label="Close">
                                                                                        <span
                                                                                            aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="well"
                                                                                        :id="'treeview_json_mark'">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2"></td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-primary"
                                                                            @click="
                                                                                add_new()
                                                                                ">
                                                                            حفظ
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
            <!-- <span class="h2"> الموردين</span> -->

            <div style="display: flex;float: left; margin: 5px">


              <button @click="Export()">
                <i class="fas fa-file-export" style="font-size: 24px; color: #ee335e"></i>
              </button>

              <button @click="Import()">
                <i class="fas fa-file-import" style="font-size: 24px; color: #22c03c"></i>
              </button>

              <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button"
                aria-haspopup="true" aria-expanded="true" placeholder="بحث" v-model="word_search"
                @input="get_search()" />
            </div>
          </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table text-md-nowrap" id="example1">
                                        <thead>
                                            <tr>
                                                <th class="wd-15p border-bottom-0">الرقم التسلسلي</th>
                                                <th class="wd-15p border-bottom-0">
                                                    التصنيف
                                                </th>
                                                <th class="wd-15p border-bottom-0">
                                                    البنك
                                                </th>

                                                <!-- <th class="wd-15p border-bottom-0"> رقم الحساب</th> -->
                                                <!-- <th class="wd-15p border-bottom-0">العمليات</th> -->
                                            </tr>
                                        </thead>
                                        <tbody v-if="
                                            list_data &&
                                            list_data.data.length > 0
                                        ">
                                            <tr v-for="(
                                                    banks, index
                                                ) in list_data.data" :key="index">
                                                <td>{{ index + 1 }}</td>
                                                <td>{{ banks.name }}</td>
                                                <td>{{ banks.bank_name }}</td>
                         
                                                <!-- <td>{{ daily.account_id }}</td> -->


                                            </tr>
                                   
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td align="center" colspan="7">
                                                    <h3>لايوجد بيانات</h3>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <pagination align="center" :data="list_data" @pagination-change-page="list"></pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import pagination from "laravel-vue-pagination";
import operation from "../../../../operation1.js";
import tree from "../../../../../js/tree/tree.js";
export default {
    mixins: [operation, tree],
    components:[pagination],
    data() {
        return {

            account: [],
            code: [],
            type_group: [],
            type_groups: "",
            group_lists:'',
            banks:'',
            bank:[],
            group: [],
            groups: "",

            count_accounts: "",
        };
    },
    mounted() {
        this.counts[0] = 1;
        this.type_of_tree = 1;
        this.type = "Mark";
        this.list();
        this.showtree("mark", "tree_account");
    },

    methods: {
        add_new() {
            this.axios
                .post("/store_account_setting/bank", {
                    count: this.counts,
                    bank: this.bank,
                    group: this.group,
                })
                .then(function (response) {
                    // e.preventDefault();
                    toastMessage("تم الاضافه بنجاح");
                    this.list();
                })
                .catch(function (error) {
                    currentObj.output = error;
                });

            // this.$router.go(0);
        },

        // onchange(index) {
        //     this.axios
        //         .post(`/get_bank_group/${this.type_group[index]}`)
        //         .then(({ data }) => {
        //             var arrayLength = data.groups.length;
        //             console.log(arrayLength);
        //             var html = "<option></option>";

        //             for (var i = 0; i < arrayLength; i++) {
        //                 html =
        //                     html +
        //                     `<option  value= ${data.groups[i].id} >${data.groups[i].name}  </option>`;
        //             }

        //             $(`#group${index}`).html(html);
        //         });
        // },

        list() {
            this.axios.post(`/mark_bank`).then(({ data }) => {
                // console.log('muhibxcd', data.count_account);
                this.groups = data.groups;
                this.banks = data.banks;
                this.list_data = data.group_lists;
            });
        },
    },
};
//
</script>
