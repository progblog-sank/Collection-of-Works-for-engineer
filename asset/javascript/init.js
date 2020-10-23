/**
 * 一覧ページでコメント記入時、ボタンの表示
 */
document.addEventListener('DOMContentLoaded',function() {
  var textArea = document.querySelectorAll('.reaction-coment textarea');
  for(var i = 0; i < textArea.length; i++){
    textArea[i].addEventListener('click',function(){
        this.parentNode.nextElementSibling.classList.add('is-active');
      },false);
  }
},false);

/**
 * 一覧ページでナイスクリック時、ナイスの表示色変更
 */
document.addEventListener('DOMContentLoaded',function() {
  var niceBtn = document.querySelectorAll('.reaction-favorite button');
  for(var i = 0; i < niceBtn.length; i++){
    niceBtn[i].addEventListener('click',function(){
      console.log(this.children)
        this.firstElementChild.classList.toggle('is-active');
      },false);
  }
},false);

/**
 * 新規登録ページで詳細を登録する時の処理
 */
document.addEventListener('DOMContentLoaded',function() {
  var detailsBtn = document.querySelectorAll('.form-area-layout-detail-display');
  for(var i = 0; i < detailsBtn.length; i++){
    detailsBtn[i].addEventListener('click',function(){
      console.log(this.children)
        this.nextElementSibling.classList.toggle('is-active');
      },false);
  }
},false);
/**
 * 削除確認画面
 */
// function disp(){
//   if(window.confirm('削除してもよろしいでしょうか？')){
//     return true;
//   }
// }
/**
 * 255字制限
 */
document.addEventListener('DOMContentLoaded',function() {
  var textArea = document.querySelector('.form-area textarea');
  
},false);