export default function(data) {
  let time = new Date(parseInt(data))
  let year = time.getFullYear()
  let month = ('0' + (time.getMonth() + 1)).substr(-2)
  let date = ('0' + time.getDate()).substr(-2)
  let min = ('0' + time.getMinutes()).substr(-2)
  let sec = ('0' + time.getSeconds()).substr(-2)
  return `${year}/${month}/${date} ${min}:${sec}`
}