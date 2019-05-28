export default function(text) {
  if (!text) return
  let newText
  if (text.indexOf('username') >= 0) newText = text.split('username').join('姓名')
  if (text.indexOf('title') >= 0) newText = text.split('title').join('職稱')
  if (text.indexOf('desc') >= 0) newText = text.split('desc').join('個人介紹')
  if (text.indexOf('image_avatar') >= 0) newText = text.split('image_avatar').join('講者照片')
  if (text.indexOf('classTitle') >= 0) newText = text.split('classTitle').join('演講主題')
  if (text.indexOf('classTitleEn') >= 0) newText = text.split('classTitleEn').join('演講主題(英文)')
  if (text.indexOf('classDesc') >= 0) newText = text.split('classDesc').join('演講摘要')
  if (text.indexOf('classDescEn') >= 0) newText = text.split('classDescEn').join('演講摘要(英文)')

  return newText
}