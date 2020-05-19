<template>
  <div class="row">
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
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
