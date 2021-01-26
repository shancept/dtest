<template>
  <div :style="{backgroundColor: color}">
    <h2>{{title}}</h2>
    <el-table
        :data="data"
        stripe
        style="width: 100%"
        empty-text="пусто">
      <el-table-column
          prop="title"
          label="Заголовок">
      </el-table-column>
      <el-table-column
          prop="value"
          label="Значение">
        <template slot-scope="scope">
          <el-input placeholder="Введите" @input="changeItem(scope.$index, $event)" :value="scope.row.value"></el-input>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
export default {
name: "Set",
  props: ['title','data', 'color', 'type'],
  methods: {
    changeItem(index, value) {
      this.$store.commit('updateState', {type: this.type, name: this.title, key: index, item: value});
      this.$emit('changed');
    },
  }
}
</script>

<style scoped>
 h2 {
   padding: 6px;
 }
</style>