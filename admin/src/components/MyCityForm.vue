<template>
  <el-dialog :title="isUpdate ? 'Обновить' : 'Добавить'" :visible.sync="formVisible">
    <el-form :model="form">
      <el-form-item :label="city.attributeLabels['id']" label-width="150px">
        <el-autocomplete
            class="inline-input"
            v-model="form.address"
            :fetch-suggestions="querySearch"
            placeholder="Начните вводить"
            :trigger-on-focus="false"
            @select="handleSelect"
            v-if="!isUpdate"
        >
          <template slot-scope="{ item }">
            <div class="address">{{ item.address }}</div>
          </template>
        </el-autocomplete>
        <el-input v-else :value="form.address" :disabled="true"></el-input>
      </el-form-item>
      <el-form-item :label="city.attributeLabels['adds']" label-width="150px">
        <el-input v-model="form.adds"></el-input>
      </el-form-item>
      <el-form-item :label="city.attributeLabels['tel']" label-width="150px">
        <el-input v-model="form.tel"></el-input>
      </el-form-item>
      <el-form-item :label="city.attributeLabels['tel2']" label-width="150px">
        <el-input v-model="form.tel2"></el-input>
      </el-form-item>
      <el-form-item :label="city.attributeLabels['company']" label-width="150px">
        <el-input v-model="form.company"></el-input>
      </el-form-item>
      <el-form-item :label="city.attributeLabels['image']" label-width="150px">
        <el-input v-model="form.image"></el-input>
      </el-form-item>
      <div class="sub-title">Координаты</div>
      <el-row>
        <el-col :span="12">
          <el-form-item :label="city.attributeLabels['geo_lat']" label-width="150px">
            <el-input class="coordinate" v-model="form.geo_lat"></el-input>
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item :label="city.attributeLabels['geo_lon']" label-width="150px">
            <el-input class="coordinate" v-model="form.geo_lon"></el-input>
          </el-form-item>
        </el-col>
      </el-row>
    </el-form>
    <span slot="footer" class="dialog-footer">
    <el-button @click="formVisible = false">Отменить</el-button>
    <el-button :loading="loading" type="primary" @click="save">{{ isUpdate ? 'Обновить' : 'Сохранить' }}</el-button>
  </span>
  </el-dialog>
</template>

<script>
import {getToken} from '@/helpers/helper'

export default {
  name: "MyForm",
  props: [],
  data() {
    return {
      form: {
        id: '',
        address: '',
        adds: '',
        tel: '',
        tel2: '',
        company: '',
        geo_lat: '',
        geo_lon: '',
        image: '',
      },
      loading: false
    }
  },
  computed: {
    formVisible: {
      get() {
        return this.$store.state.formVisible;
      },
      set(val) {
        this.$store.commit('set', {type: 'formVisible', data: val})
      },
    },
    formUpdate: {
      get() {
        return this.$store.state.formUpdate;
      },
      set(val) {
        this.$store.commit('set', {type: 'formUpdate', data: val})
      }
    },
    city() {
      return this.$store.state.city;
    },
    isUpdate() {
      return Object.keys(this.formUpdate).length > 0;
    }
  },
  watch: {
    formUpdate() {
      for (let item in this.form) {
        this.form[item] = '';
        if (typeof this.formUpdate[item] !== 'undefined') {
          this.form[item] = this.formUpdate[item];
        }
      }
    }
  },
  methods: {
    querySearch(queryString, cb) {
      if (queryString.length > 2) {
        this.axios.get('/api/city/search', {
          params: {
            query: queryString
          }
        }).then((res) => {
          cb(res.data.result);
        })
      }
    },
    handleSelect(item) {
      for (let key in this.form) {
        this.form[key] = item[key]
      }
    },
    save() {
      this.loading = true;
      if (this.isUpdate) {
        return this.update()
      }
      return this.insert()
    },
    insert() {
      this.axios.post('/api/city/', this.getForm())
          .then(response => {
            if (response.data.code === 200 && response.data.result.result === 'success') {
              this.$store.dispatch('getData', 'city');
              this.$notify({
                title: 'Успех',
                message: 'Сохранено успешно',
                type: 'success'
              });
              this.formVisible = false;
            } else {
              this.$notify.error({
                title: 'Ошибка',
                message: 'Ошибка сохранения'
              });
            }
            this.loading = false;
          });
    },
    update() {
      let url = '/api/city/' + this.formUpdate.id;
      this.axios.put(url, this.getForm()).then(response => {
        if (response.data.code === 200 && response.data.result.result === 'success') {
          this.$store.dispatch('getData', 'city');
          this.$notify({
            title: 'Успех',
            message: 'Обновлено успешно',
            type: 'success'
          });
          this.formVisible = false;
        } else {
          this.$notify.error({
            title: 'Ошибка',
            message: 'Ошибка сохранения'
          });
        }
        this.loading = false;
      });
    },
    getForm() {
      // let form = this.isUpdate ? new URLSearchParams() : new FormData, key;
      let form = new FormData;
      form.append('access-token', getToken());
      for (let key in this.form) {
        form.append(key, this.form[key]);
      }
      return form;
    },
  }
}
</script>

<style lang="scss">
.coordinate {
  width: 50%
}

.el-form {
  .sub-title {
    text-align: center;
  }

  .el-autocomplete {
    width: 100%;
  }
}
</style>