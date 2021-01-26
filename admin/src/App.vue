<template>
  <el-container style="border: 1px solid #eee">
    <my-aside/>
    <my-content/>
  </el-container>
</template>

<script>
import myAside from './components/Aside'
import myContent from './components/Content'

export default {
  components: {myAside, myContent}
};
</script>