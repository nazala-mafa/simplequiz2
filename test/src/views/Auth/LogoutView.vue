<script>
export default {
  created() {
    localStorage.removeItem('token')
    return this.$router.push('/login')
  }
}
</script>