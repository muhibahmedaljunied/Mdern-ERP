<template>


    <div class="content container-fluid">



        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <span class="h4">تطبيق لوائح الانصراف</span>
                        </div>

                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-2">
                                <label for="status"> نوع الانصراف</label>

                                <select v-model="leaveselected" name="type" class="form-control " required>
                                    <option v-for="leave in leave_types" v-bind:value="leave.id">
                                        {{ leave.name }}
                                    </option>
                                </select>

                            </div>

                            <div class="col-md-2">
                                <label for="status">المده</label>
                                <select v-model="leave_part_selected" class="form-control " required>
                                    <option v-for="leave_part in leave_parts" v-bind:value="leave_part.id">
                                        {{ leave_part.name }}
                                    </option>
                                </select>
                            </div>
                            <!-- <div class="col-md-2">
                                <label for="status"> عدد المرات</label>
                                <select v-model="iterationselected" name="type"
                                    class="form-control " required>
                                    <option v-for="iteration in iterations" v-bind:value="iteration.id">
                                        {{ iteration.name }}
                                    </option>
                                </select>




                            </div> -->




                            <div class="col-sm-6 col-md-2" style="margin-top: auto;">


                                <a  id="agregar_productos"
                                    data-target=".bs-example-modal-sm">
                                    <img src="/assets/img/search.png" alt="" style="width: 15%;"></a>
                            </div>



                        </div>




                    </div>


                </div>
            </div>
        </div>


        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">

                    <div class="card-body" id="printme">


                        <form action="post">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>

                                            <th class="wd-10p border-bottom-0">اسم المؤظف</th>

                                            <th class="wd-10p border-bottom-0">عدد المرات</th>
                                            <th class="wd-10p border-bottom-0">اليوم</th>
                                            <th class="wd-10p border-bottom-0">المده</th>
                                            <th class="wd-10p border-bottom-0"> اللائحه </th>




                                        </tr>
                                    </thead>
                                    <tbody v-if="value_list && value_list.data.length > 0">
                                        <tr v-for="(staff, indexs) in value_list.data" :key="indexs">
                                       


                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>



                                            </td>






























                                        </tr>



                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td align="center" colspan="3">لايوجد بياتات.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- <a href="javascript:void" @click="Add_new()" class="btn btn-success"><span>تاكيد
                  العمليه</span></a> -->
                        </form>
                        <pagination align="center" :data="value_list" @pagination-change-page="list"></pagination>
                    </div>


                </div>
            </div>
        </div>



    </div>

</template>

<script>

import pagination from "laravel-vue-pagination";
import operation from '../../../../staff/operation/operation.js';

export default {
    components: {
        pagination,
    },
    mixins: [operation],
    data() {
        return {
      
            leave_types:'',
            leave_parts:'',
            leaveselected: [],
            leave_part_selected: [],






        };
    },
    mounted() {
        this.list();
        this.type = 'attendance';
    },
    methods: {









        list(page = 1) {
            this.axios
                .post(`/leave_sanction?page=${page}`)
                .then(({ data }) => {
                    this.leave_types = data.leave_types;
                    this.leave_parts = data.leave_parts;
                    this.value_list = data.list;
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },



    },
};
</script>
