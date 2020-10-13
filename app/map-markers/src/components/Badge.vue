<!-- Template -->
<template>
    <div class="badge">
      <div v-if="Image" class="badge-image"><img :src="Image" alt=""></div>
      <div class="badge-meta">
        <h2>{{ Name }}</h2>
        <div class="types">
          <div :class="'type type-' + type.term_id" v-for="(type, key) in Types" :key="key">
            {{ type.name }}
          </div>
        </div>
      </div>
    </div>
</template>
<!-- Script -->
<script>
  export default {
    name: 'Badge',
    props: {
      Name: String,
      Image: String,
      Types:Array
    },
  }
</script>  
<!-- Style -->
<style scoped>
  .badge {
      box-shadow: 0px 0px 0px 2px #B3E4F5;
      margin-bottom: 10px;
      padding: 10px 20px;
      display: flex;
      flex-wrap: wrap;
      cursor: pointer;
  }
  .badge h2{
      width:100%;
      margin:0;
  }
  .badge-meta{
    margin-right: 10px;
    margin-top: 5px;
  }

  .types {
      width: 100%;
      display: grid;
      grid-template-columns: auto 1fr;
      grid-gap: 5px;
      text-align: right;
  }
  .types .type {
      font-size: 12px;
  }
  .types .type:not(:first-child):before {
      content:"•";
  }

  .badge-image img {
      box-shadow: 0px 0px 0px 1px #748388;
      border-radius: 50%;
      width: 100%;
      max-width: 70px;
  }
</style>