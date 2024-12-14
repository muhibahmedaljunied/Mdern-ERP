<template>
    <div class="container-fluid">
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h2>ترميز الموارد البشريه</h2>
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
                                                                    <th>
                                                                        نوع
                                                                        التصنيف
                                                                    </th>
                                                                    <th>
                                                                        التصنيف
                                                                    </th>
                                                                    <!-- <th>
                                                                        الحساب
                                                                    </th> -->

                                                                    <th> البند </th>

                                                                    <!-- <th>رقم الحساب </th> -->

                                                                    <th>
                                                                        اضافه
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr v-for="index in count" :key="index">
                                                                    <td>
                                                                        <select style="
                                                                                background-color: beige;
                                                                            " name="forma_pago" class="form-control"
                                                                            v-model="type_group[
                                                                                index
                                                                            ]
                                                                                " v-on:change="
                                                                                    onchange(
                                                                                        index
                                                                                    )
                                                                                    ">
                                                                            <!-- <option v-bind:value="1">الكل</option> -->
                                                                            <option v-for="types in type_groups"
                                                                                v-bind:value="[types.group_type_id, types.group_type_code]
                                                                                    ">
                                                                                {{
                                                                                    types.type_name
                                                                                }}
                                                                            </option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select style="
                                                                                background-color: beige;
                                                                            " name="forma_pago" class="form-control"
                                                                            v-bind:id="'group' +
                                                                                index
                                                                                " v-model="group[
                                                                                    index
                                                                                ]
                                                                                    "></select>
                                                                    </td>
                                                                    <td>
                                                                        <select style="
                                                                                background-color: beige;
                                                                            " name="forma_pago" class="form-control"
                                                                            v-bind:id="'result' +
                                                                                index
                                                                                " v-model="result[
                                                                                    index
                                                                                ]
                                                                                    "></select>
                                                                    </td>

                                                                    <!-- <td>

                                                                        <input v-model="code[index]" type="text"
                                                                            class="form-control" name="name" id="name"
                                                                            required />


                                                                    </td> -->

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
                                                                    <td colspan="3"></td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-primary"
                                                                            @click="
                                                                                add_new_account()
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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table text-md-nowrap" id="example1">
                                        <thead>
                                            <tr>
                                                <th class="wd-15p border-bottom-0">
                                                    #
                                                </th>
                                                <th class="wd-15p border-bottom-0">
                                                    نوع التصنيف
                                                </th>
                                                <th class="wd-15p border-bottom-0">
                                                    التصنيف
                                                </th>
                                                <th class="wd-15p border-bottom-0">
                                                    الحساب
                                                </th>
                                                <!-- <th class="wd-15p border-bottom-0"> رقم الحساب</th> -->
                                                <!-- <th class="wd-15p border-bottom-0">العمليات</th> -->
                                            </tr>
                                        </thead>
                                        <tbody v-if="
                                            list_data &&
                                            list_data.length > 0
                                        ">
                                            <tr v-for="(
                                                    daily, index
                                                ) in list_data" :key="index">
                                                <td>{{ index + 1 }}</td>
                                                <td>{{ daily.type_name }}</td>
                                                <td>{{ daily.name }}</td>
                                                <!-- <td>{{ daily.account_id }}</td> -->

                                                <td>{{ daily.text }}</td>
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
    components: [pagination],
    data() {
        return {

            account: [],
            code: [],
            type_group: [],
            type_groups: "",
            group: [],
            result: [],

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
        // add_new_account() {
        //     this.axios
        //         .post("/store_account_setting", {
        //             count: this.counts,
        //             account: this.account,
        //             group: this.group,
        //         })
        //         .then(function (response) {
        //             // e.preventDefault();
        //             toastMessage("تم الاضافه بنجاح");
        //         })
        //         .catch(function (error) {
        //             currentObj.output = error;
        //         });

        //     // this.$router.go(0);
        // },

        onchange(index) {
            this.axios
                .post(`/get_group_hr/${this.type_group[index][0]}`, {

                    code: this.type_group[index][1]
                })
                .then(({ data }) => {


                    var html = "<option></option>";
                    var html2 = "<option></option>";

                    if (data.groups && data.result) {

                        var arrayLength = data.groups.length;
                        var arrayLength2 = data.result.length;


                        for (var i = 0; i < arrayLength; i++) {
                            html =
                                html +
                                `<option  value= ${data.groups[i].id} >${data.groups[i].name}  </option>`;
                        }
                        for (var i = 0; i < arrayLength2; i++) {
                            html2 =
                                html2 +
                                `<option  value= ${data.result[i].id} >${data.result[i].name}  </option>`;
                        }
                    }

                    $(`#group${index}`).html(html);
                    $(`#result${index}`).html(html2);
                });
        },

        list() {
            this.axios.post(`/group_mark_hr`).then(({ data }) => {
                // console.log('muhibxcd', data.count_account);
                this.type_groups = data.group_types;
                this.list_data = data.group_lists;
            });
        },
    },
};
//
</script>
