<template>
  <el-dialog title="Добавить" :visible.sync="formVisible">
    <el-form class="route-form" :model="form" :rules="rules" ref="ruleForm">
      <el-form-item :label="route.attributeLabels['from']" label-width="150px" class="demo-ruleForm">
        <el-autocomplete
            :rules="rules.from"
            class="inline-input"
            v-model="form.from"
            :fetch-suggestions="querySearch"
            placeholder="Начните вводить"
            @select="handleSelectFrom"
        >
          <template slot-scope="{ item }">
            <div class="address">{{ item }}</div>
          </template>
        </el-autocomplete>
      </el-form-item>
      <el-form-item :label="route.attributeLabels['to']" label-width="150px">
        <el-autocomplete
            class="inline-input"
            v-model="form.to"
            :fetch-suggestions="querySearch"
            placeholder="Начните вводить"
            @select="handleSelectTo"
        >
          <template slot-scope="{ item }">
            <div class="address">{{ item }}</div>
          </template>
        </el-autocomplete>
      </el-form-item>
      <el-form-item :label="route.attributeLabels['refrigerator']" label-width="150px">
        <el-checkbox true-label="1" false-label="0" v-model="form.refrigerator">Да/Нет</el-checkbox>
      </el-form-item>
      <el-form-item :label="route.attributeLabels['delivery_time']" label-width="150px">
        <el-input class="route-number" type="text" v-model="form.delivery_time"></el-input> дней
      </el-form-item>
      <div class="sub-title">Объем</div>
      <el-form-item :label="route.attributeLabels['v1']" label-width="150px">
        <el-input class="route-number" type="number" v-model="form.v1"></el-input>
      </el-form-item>
      <el-form-item :label="route.attributeLabels['v3']" label-width="150px">
        <el-input class="route-number" type="number" v-model="form.v3"></el-input>
      </el-form-item>
      <el-form-item :label="route.attributeLabels['v5']" label-width="150px">
        <el-input class="route-number" type="number" v-model="form.v5"></el-input>
      </el-form-item>
      <el-form-item :label="route.attributeLabels['v10']" label-width="150px">
        <el-input class="route-number" type="number" v-model="form.v10"></el-input>
      </el-form-item>
      <el-form-item :label="route.attributeLabels['v20']" label-width="150px">
        <el-input class="route-number" type="number" v-model="form.v20"></el-input>
      </el-form-item>
      <el-form-item :label="route.attributeLabels['v30']" label-width="150px">
        <el-input class="route-number" type="number" v-model="form.v30"></el-input>
      </el-form-item>
      <div class="sub-title">Вес</div>
      <el-form-item :label="route.attributeLabels['w500']" label-width="150px">
        <el-input class="route-number" type="number" v-model="form.w500"></el-input>
      </el-form-item>
      <el-form-item :label="route.attributeLabels['w1000']" label-width="150px">
        <el-input class="route-number" type="number" v-model="form.w1000"></el-input>
      </el-form-item>
      <el-form-item :label="route.attributeLabels['w2000']" label-width="150px">
        <el-input class="route-number" type="number" v-model="form.w2000"></el-input>
      </el-form-item>
      <el-form-item :label="route.attributeLabels['w3000']" label-width="150px">
        <el-input class="route-number" type="number" v-model="form.w3000"></el-input>
      </el-form-item>
      <el-form-item :label="route.attributeLabels['w4000']" label-width="150px">
        <el-input class="route-number" type="number" v-model="form.w4000"></el-input>
      </el-form-item>
      <el-form-item :label="route.attributeLabels['w5000']" label-width="150px">
        <el-input class="route-number" type="number" v-model="form.w5000"></el-input>
      </el-form-item>

    </el-form>
    <span slot="footer" class="dialog-footer">
    <el-button @click="formVisible = false">Отменить</el-button>
    <el-button :loading="loading" type="primary" @click="save">Сохранить</el-button>
  </span>
  </el-dialog>
</template>

<script>
import {getToken} from '@/helpers/helper'

export default {
  name: "MyRouteForm",
  props: [],
  data() {
    return {
      form: {
        from: '',
        to: '',
        refrigerator: '',
        v1: '',
        v10: '',
        v20: '',
        v3: '',
        v30: '',
        v5: '',
        w1000: '',
        w2000: '',
        w3000: '',
        w4000: '',
        w500: '',
        w5000: '',
      },
      rules: {
        from: [
          { required: true, message: 'Поле не должно быть пустым', trigger: 'blur' }
        ],
        to: [
          { required: true, message: 'Поле не должно быть пустым', trigger: 'blur' }
        ],
        v1: [
          { required: true, message: 'Поле не должно быть пустым', trigger: 'blur' }
        ],
      },
      cityAc: [],
      loading: false,
      links: []
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
    route() {
      return this.$store.state.route;
    },
    isUpdate() {
      return Object.keys(this.formUpdate).length > 0;
    },
  },
  mounted() {
    this.$store.state.city.list.map((model) => {
      this.cityAc.push(model.city);
    })
  },
  methods: {
    querySearch(queryString, cb) {
      let links = this.cityAc;
      let res = queryString ? links.filter(this.createFilter(queryString)) : links
      cb(res);
    },
    createFilter: function (queryString) {
      return (link) => {
        return (~link.toLowerCase().indexOf(queryString.toLowerCase()));
      };
    },
    handleSelectFrom(item) {
      this.form.from = item;
    },
    handleSelectTo(item) {
      this.form.to = item;
    },
    save() {
      this.loading = true;
      let url = '/api/route';
      this.axios.post(url, this.getForm()).then(response => {
        if (response.data.code === 200 && response.data.result.result === 'success') {
          this.$notify({
            title: 'Успех',
            message: 'Обновлено успешно',
            type: 'success'
          });
          this.$store.dispatch('getData', 'route');
          this.formVisible = false;
        } else {
          for(let k in response.data.result.errors) {
            if(Array.isArray(response.data.result.errors[k])) {
              response.data.result.errors[k].map((i) => {
                this.$notify.error({
                  title: 'Ошибка поля: '+this.route.attributeLabels[k],
                  message: i
                });
              })
            }
          }
        }
        this.loading = false;
      }).catch(() => {
        this.$notify.error({
          title: 'Ошибка',
          message: 'Ошибка сохранения'
        });
        this.loading = false;
      });
    },
    getForm() {
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

<style lang="scss" scoped>
.coordinate {
  width: 50%
}

.el-form {
  .sub-title {
    text-align: left;
  }

  .el-autocomplete {
    width: 100%;
  }
}
.route-form {
  .route-number, .route-text {
    width: 100px;
  }
}
</style>