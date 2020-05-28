<template>
  <div class="row" v-if="$gate.isAdmin()" >
    <div class="col-lg-12">
      <passport-clients></passport-clients>
    </div>
    <div class="col-lg-12">
      <passport-authorized-clients></passport-authorized-clients>
    </div>
    <div class="col-lg-12">
      <passport-personal-access-tokens></passport-personal-access-tokens>
    </div>
  </div>
  <div class="row" v-else >
    <unauthorized></unauthorized>
  </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
