<template>
  <!-- row opened -->

  <div class="container-fluid">
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">

            <span class="h2"> البدلات</span>
            <div style="display: flex;float: left; margin: 5px">




              <div>

              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="card-body">

        <div class="row row-sm">
          <div class="col-xl-12">
            <div class="card">

              <div class="card-body">
                <form method="post" enctype="multipart/form-data">

                  <div class="table-responsive">
                    <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                      <thead>
                        <tr>
                          <th> البدل</th>
                          <th> نوع البدل</th>
                          <!-- <th> التصنيف</th> -->


                          <th>اضافه</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="index in count" :key="index">
                          <td>
                            <input v-model="allowance[index]" type="text" class="form-control" name="name" id="name"
                              required />

                          </td>

                          <td>

                            <select v-model="allowance_type[index]" id="inputState" class="form-control">
                              <option v-bind:value="1">
                                شهري
                              </option>
                              <option v-bind:value="2">

                                غير شهري

                              </option>
                            </select>

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
                          <td colspan="2"></td>
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

        </div>
      </div>

    </div>
    <div class="row row-sm">
      <div class="col-xl-12">
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
                aria-haspopup="true" aria-expanded="true" placeholder="بحث " v-model="word_search"
                @input="get_search()" />
            </div>
          </div>

          <div class="card-body" id="printme">
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">#</th>
                    <th class="wd-15p border-bottom-0"> البدل</th>
                    <th class="wd-15p border-bottom-0">نوع البدل</th>
                    <!-- <th class="wd-15p border-bottom-0"> التصنيف</th> -->



                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="allowance_types && allowance_types.length > 0">
                  <tr v-for="(allowance_type, index) in allowance_types" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td>{{ allowance_type.name }}</td>
                    <td v-if="allowance_type.status == 0">

                      غبر شهري
                    </td>
                    <td v-else>
                      شهري
                    </td>

                    <!-- <td>{{ allowance_type.name }}</td> -->
                    <td>
                      <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                      <button type="button" @click="delete_allowance_type(allowance_type.id)"
                        class="btn btn-sm waves-effect btn-danger">
                        <i class="fa fa-trash"></i>
                      </button>

                      <router-link :to="{
                        name: 'edit_allowance_types',
                        params: { id: allowance_type.id },
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
            <pagination align="center" :data="allowance_types" @pagination-change-page="list"></pagination>
          </div>
        </div>
      </div>


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
      allowance_types: {
        type: Object,
        default: null,
      },
      allowance: [],
      allowance_type: [],
      // groups:'',
      // group:[],


    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;
    this.type = 'allowance';
  },
  methods: {

    Add_new() {

      this.axios
        .post(`/store_allowance_type`, {
          count: this.counts,
          allowance_type: this.allowance_type,
          // group: this.group,
          allowance: this.allowance,

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
        .post(`/allowance_type?page=${page}`)
        .then(({ data }) => {
          this.allowance_types = data.allowance_types;
          // this.groups = data.groups;

        })
        .catch(({ response }) => {
          console.error(response);
        });
    },



  },
};
</script>
