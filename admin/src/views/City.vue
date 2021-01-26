<template>
  <el-main>
    <h1>Активные города</h1>
    <el-button @click="formVisible = true; formUpdate = {}" type="success">Добавить</el-button>
    <my-city-form/>
    <el-table
        :data="city.list"
        stripe
        lazy
        empty-text="пусто"
        style="width: 100%">
      <el-table-column
          prop="address"
          :label="city.attributeLabels['address']">
      </el-table-column>
      <el-table-column
          prop="geo_lat"
          :label="city.attributeLabels['geo_lat']">
      </el-table-column>
      <el-table-column
          prop="geo_lon"
          :label="city.attributeLabels['geo_lon']">
      </el-table-column>
      <el-table-column
          prop="adds"
          :label="city.attributeLabels['adds']">
      </el-table-column>
      <el-table-column
          prop="tel"
          :label="city.attributeLabels['tel']">
      </el-table-column>
      <el-table-column
          prop="tel2"
          :label="city.attributeLabels['tel2']">
      </el-table-column>
      <el-table-column
          prop="company"
          :label="city.attributeLabels['company']">
      </el-table-column>
      <el-table-column
          label="Действия">
        <template slot-scope="scope">
          <el-button
              size="mini"
              @click="handleEdit(scope.row)">Изменить</el-button>
          <el-button
              size="mini"
              type="danger"
              @click="handleDelete(scope.row)">Удалить</el-button>
        </template>
      </el-table-column>
    </el-table>
  </el-main>
</template>

<script>
import MyCityForm from "@/components/MyCityForm";
import {getToken} from "@/helpers/helper";
import {Loading} from "element-ui";

export default {
  name: "City",
  components: {MyCityForm},
  computed: {
    city() {
      return this.$store.state.city;
    },
    formVisible: {
      get() {
        return this.$store.state.formVisible;
      },
      set(val) {
        this.$store.commit('set', {type: 'formVisible', data: val})
      }
    },
    formUpdate: {
      get() {
        return this.$store.state.formUpdate;
      },
      set(val) {
        this.$store.commit('set', {type: 'formUpdate', data: val})
      }
    },
  },
  methods: {
    handleEdit(row) {
      this.formVisible = true;
      this.formUpdate = row;
    },
    handleDelete(row){
      let loadingInstance = Loading.service({fullscreen: true});
      let url = '/api/city/' + row.id;
      this.axios.delete(url, {data: {'access-token': getToken()}}).then(response => {
        if (response.data.code === 200 && response.data.result.result === 'success') {
          this.$store.dispatch('getData', 'city');
          this.$notify({
            title: 'Успех',
            message: 'Удалено',
            type: 'success'
          });
        } else {
          this.$notify.error({
            title: 'Ошибка',
            message: 'Не удалено'
          });
        }
        loadingInstance.close();
      }).catch(error => {
        loadingInstance.close();
        let m;
        try {
          m = error.response.data.result.message;
        } catch {
          m = 'Обратитесь к программисту';
        }
        this.$notify({
          title: 'Ошибка',
          message: m,
          type: 'error'
        });
      });
    }
  }
}
</script>

<style scoped>

</style>