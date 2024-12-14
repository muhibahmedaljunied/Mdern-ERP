<template>
  <div class="container-fluid">

    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">

            <span class="h2">نوع التاخير</span>
            <div style="display: flex;float: left; margin: 5px">


              <input autocomplete="on" v-model="word_search" type="text" class="form-control input-text"
                placeholder="بحث ...." aria-label="Recipient's username" aria-describedby="basic-addon2"
                @input="get_search()">

              <div>

              </div>
            </div>
          </div>
          <div class="card-body">
            <form method="post" enctype="multipart/form-data">

              <div class="table-responsive">
                <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                  <thead>
                    <tr>

                      <th> النوع</th>



                      <!-- <th >التصنيف</th> -->




                      <th>اضافه</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="index in count" :key="index">
                      <td>
                        <input v-model="name[index]" type="text" class="form-control" name="name" id="name" required />

                      </td>


                      <!-- <td>
                        <select v-model="group[index]" id="inputState" class="form-control">
                          <option v-for="group in groups" v-bind:value="group.id">
                            {{ group.name }}
                          </option>

                        </select>
                      </td> -->


                      <td v-if="index == 1">
                        <a class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="addComponent(count)">
                          <i class="fa fa-plus-circle"></i></a>

                        <a class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="disComponent(count)">
                          <i class="fa fa-minus-circle"></i></a>
                      </td>



                    </tr>

                    <tr>
                      <td></td>
                      <td>
                        <button type="button" class="btn btn-primary" @click="Add_new()">حفظ </button>
                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>
            </form>

          </div>

        </div>
      </div>
      <!--/div-->
    </div>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">

          <div class="card-body" id="printme">
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">#</th>
                    <th class="wd-15p border-bottom-0">النوع</th>

                    <!-- <th class="wd-15p border-bottom-0">التصنيف</th> -->

                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="delay_types && delay_types.length > 0">
                  <tr v-for="(delay_type, index) in delay_types" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td>{{ delay_type.name }}</td>

                    <!-- <td>{{ delay_type.name }}</td> -->
                    <td>
                      <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                      <button type="button" @click="delete_delay_type(delay_type.id)"
                        class="btn btn-sm waves-effect btn-danger">
                        <i class="fa fa-trash"></i>
                      </button>

                      <router-link :to="{
                        name: 'edit_branch',
                        params: { id: delay_type.id },
                      }" class="edit btn btn-sm waves-effect btn-success">
                        <i class="fa fa-edit"></i></router-link>
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
            <pagination align="center" :data="delay_types" @pagination-change-page="list"></pagination>
          </div>

        </div>
      </div>
      <!--/div-->
    </div>
  </div>
</template>

<script>

import pagination from "laravel-vue-pagination";
import operation from '../../../../../js/staff/BasicData/operation.js';

export default {
  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {


      delay_types:'',



    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;

    this.type = 'delay_type';
  },
  methods: {
    Add_new() {

      this.axios
        .post(`/store_delay_type`, {
          count: this.counts,
          type: this.type,
          name: this.name,
          // group:this.group,

        }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });






    },
    list(page = 1) {
      this.axios
        .post(`/delay_type?page=${page}`)
        .then(({ data }) => {
          this.delay_types = data.delay_types;
          // this.groups = data.groups;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },



  },
};
</script>
