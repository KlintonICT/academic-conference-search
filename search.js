$(document).ready(() => {
  // Press Enter to search
  $("#txtconfname").keyup(function(event){
      if(event.keyCode === 13){
          $("#btnsearch").click();
      }
  })
  // click search button to search
  $("#btnsearch").click(function(){
      search($("#txtconfname").val());
  });
  // pass key word to every functions
  function search(query) {
    searchDescription(query)
    searchVideos(query)
    searchTweets(query)
  }
  // search key word by IEEE website in order to get description
  function searchDescription(query) {
    search(query)

    function search(query){
      $.ajax({ //use ajax in calling data as JSON
        url: 'http://ieeexploreapi.ieee.org/api/v1/search/articles', //link in website that the data will return
        data:{
          article_title: query, // search key word by title in IEEE website
          content_type: "Conferences", //type of the result is conference
          max_records: 10, //will get 10 result after searching
          apikey: 'rm6ne8t8gdx8gnf57m85jjp4' //IEEE API key
        },
      }).done(function(data){ //(call back function) choose the information from JSON and return it as html
        console.log(data)
        if ('articles' in data) {
          const des = data.articles.map((item) => {
            let html = '<div class="descript" style="border: 0.5px solid black; width:100%; margin-bottom:20px; padding: 20px;border-radius:10px;box-shadow: 5px 5px #888888">'
            html +=
              '<h6 class="card-title">' +
              '<a data-fancybox-type="iframe" class="fancyboxIframe" href="' +
              item.abstract_url + '">' + item.publication_title + "</a>" +
              "</h6>" +
              "<p>" + item.abstract + "</p>" +
              '<small class="card-text"> At ' + item.conference_location + "</small><br/>" +
              "<small>On " +
              item.conference_dates +
              "</small><br/>" +
              '<small><a data-fancybox-type="iframe" class="fancyboxIframe" href="' +
              item.pdf_url +
              '">Learn More</a></small>' + '</div>'
            return html
          })

          $('#list_des').html(des.join(''))
        } else {
          $('#list_des').html('<h3 class="text-center">"' + query + '" description not found.</h3>')
        }
      })
    }
  }
  // Search video conference in youtube
  function searchVideos(query) {
    search(query)
    function search(query) {
      $.ajax({ // use ajax to call the data as JSON
        url: 'https://www.googleapis.com/youtube/v3/search', //youtube link
        data: {
          key: 'AIzaSyCbESbmPKpvnqMJc_d-Y6MQVgEuuncIGsc', //youtube API key
          part: 'snippet', //return some information like videoID, thumbnail, etc
          type: 'video', // return it as video type
          maxResults: '20', //will get 20 results after searching
          //add academic conference to search keyw word in order to get all conference video which is related to that key word
          q: query+", academic conference",
        }
      }).done(function (data) {//(call back function) choose the information from JSON and return it as html
        const videos = data.items.map((item) => {
          let html = '<div class="col-lg-3 col-md-4 col-sm-6">'
          html += '<a href="https://youtu.be/' + item.id.videoId + '">'
          html += '<img class="thumbnail" src="' + item.snippet.thumbnails.medium.url + '" width="100%"/>'
          html += '<p style="color:black">' + item.snippet.title + '</p>'
          html += '</a></div>'
          return html
        })
        $('#list_video').html(videos.join(''))
      })
    }
  }
  //search comment conference by twitter
  function searchTweets(query){
    search(query)


    function sentimentCheck(msg) {
      // dc73ee1d83164ed7a93db8d5afbdb358
      // 864addb2a8114d6eb9acd30ff898be52
      return new Promise((resolve) => {

      })
    }

    function search(){
      $.ajax({
        url: '/twitter.php', //link to twitter.php file
        data:{
          //add conference to search keyw word in order to get all conference video which is related to that key word
          q: query + ' conference'
        },
        method: 'POST',
      }).done(function(data){
        $('#list_twitter').html(data) //show the result on page after getting the result from twitter.php file
      })
    }
  }
})