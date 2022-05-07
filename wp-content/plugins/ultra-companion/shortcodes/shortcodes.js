(function() {
   tinymce.PluginManager.add('ultra_mce_button', function( editor, url ) {
      editor.addButton( 'ultra_mce_button', {
         text: 'Short Codes',
         icon: false,
         type: 'menubutton',
         menu: [
            {
               text: 'Layouts',
               menu: [
                  {
                     text: 'Grid',
                     onclick: function() {
                        editor.windowManager.open( {
                           title: 'Insert no columns to show in a row',
                           id:'column-selector',
                           body: [
                              {
                                 type: 'listbox',
                                 name: 'columns',
                                 label: 'No of Columns',
                                 id :'no-of-columns',
                                 'values': [
                                    {text: '1', value: '1'},
                                    {text: '2', value: '2'},
                                    {text: '3', value: '3'},
                                    {text: '4', value: '4'},
                                    {text: '5', value: '5'},
                                    {text: '6', value: '6'},
                                 ]
                              },
                              {
                                 type: 'listbox',
                                 name: 'first_column',
                                 label: 'First Column Width',
                                 id:'first_column',
                                 'values': [
                                    {text: '1', value: '1'},
                                    {text: '2', value: '2'},
                                    {text: '3', value: '3'},
                                    {text: '4', value: '4'},
                                    {text: '5', value: '5'},
                                    {text: '6', value: '6'},
                                 ]
                              },
                              {
                                 type: 'listbox',
                                 name: 'second_column',
                                 label: 'Second Column Width',
                                 id:'second_column',
                                 'values': [
                                    {text: '1', value: '1'},
                                    {text: '2', value: '2'},
                                    {text: '3', value: '3'},
                                    {text: '4', value: '4'},
                                    {text: '5', value: '5'},
                                    {text: '6', value: '6'},
                                 ]
                              },
                              {
                                 type: 'listbox',
                                 name: 'third_column',
                                 label: 'Third Column Width',
                                 id:'third_column',
                                 'values': [
                                    {text: '1', value: '1'},
                                    {text: '2', value: '2'},
                                    {text: '3', value: '3'},
                                    {text: '4', value: '4'},
                                    {text: '5', value: '5'},
                                    {text: '6', value: '6'},
                                 ]
                              },
                              {
                                 type: 'listbox',
                                 name: 'fourth_column',
                                 label: 'Fourth Column Width',
                                 id:'fourth_column',
                                 'values': [
                                    {text: '1', value: '1'},
                                    {text: '2', value: '2'},
                                    {text: '3', value: '3'},
                                    {text: '4', value: '4'},
                                    {text: '5', value: '5'},
                                    {text: '6', value: '6'},
                                 ]
                              },
                              {
                                 type: 'listbox',
                                 name: 'fifth_column',
                                 label: 'Fifth Column Width',
                                 id:'fifth_column',
                                 'values': [
                                    {text: '1', value: '1'},
                                    {text: '2', value: '2'},
                                    {text: '3', value: '3'},
                                    {text: '4', value: '4'},
                                    {text: '5', value: '5'},
                                    {text: '6', value: '6'},
                                 ]
                              },
                              {
                                 type: 'listbox',
                                 name: 'sixth_column',
                                 label: 'Sixth Column Width',
                                 id:'sixth_column',
                                 'values': [
                                    {text: '1', value: '1'},
                                    {text: '2', value: '2'},
                                    {text: '3', value: '3'},
                                    {text: '4', value: '4'},
                                    {text: '5', value: '5'},
                                    {text: '6', value: '6'},
                                 ]
                              },

                           ],
                           onsubmit: function( e ) {
                              
                                 if(e.data.columns == 1){
                                    editor.insertContent( 
                                   '[ultra_column_wrap]<br />'+ 
                                   '[ultra_column span="'+e.data.first_column+'"]Put your column 1 text[/ultra_column]<br />'+
                                   '[/ultra_column_wrap]<br />'
                                    );
                                 }else if(e.data.columns == 2){
                                    if((parseInt(e.data.first_column) + parseInt(e.data.second_column)) < 7 ){
                                    editor.insertContent( 
                                    '[ultra_column_wrap]<br />'+ 
                                    '[ultra_column span="'+e.data.first_column+'"]Put your column 1 text[/ultra_column]<br />'+
                                    '[ultra_column span="'+e.data.second_column+'"]Put your column 2 text[/ultra_column]<br />'+
                                    '[/ultra_column_wrap]<br />'
                                    );
                                    }else{
                                       alert('Invalid! Sum of columns should not exceed 6');
                                 }
                                 }else if(e.data.columns == 3){
                                    if((parseInt(e.data.first_column) + parseInt(e.data.second_column) + parseInt(e.data.third_column)) < 7 ){
                                    editor.insertContent( 
                                    '[ultra_column_wrap]<br />'+ 
                                    '[ultra_column span="'+e.data.first_column+'"]Put your column 1 text[/ultra_column]<br />'+
                                    '[ultra_column span="'+e.data.second_column+'"]Put your column 2 text[/ultra_column]<br />'+
                                    '[ultra_column span="'+e.data.third_column+'"]Put your column 3 text[/ultra_column]<br />'+
                                    '[/ultra_column_wrap]<br />'
                                    );
                                    }else{
                                    alert('Invalid! Sum of columns should not exceed 6');
                                 }
                                 }else if(e.data.columns == 4){
                                    if((parseInt(e.data.first_column) + parseInt(e.data.second_column) + parseInt(e.data.third_column) + parseInt(e.data.fourth_column)) < 7 ){
                                     editor.insertContent( 
                                    '[ultra_column_wrap]<br />'+ 
                                    '[ultra_column span="'+e.data.first_column+'"]Put your column 1 text[/ultra_column]<br />'+
                                    '[ultra_column span="'+e.data.second_column+'"]Put your column 2 text[/ultra_column]<br />'+
                                    '[ultra_column span="'+e.data.third_column+'"]Put your column 3 text[/ultra_column]<br />'+
                                    '[ultra_column span="'+e.data.fourth_column+'"]Put your column 4 text[/ultra_column]<br />'+
                                    '[/ultra_column_wrap]<br />'
                                    );
                                     }else{
                                    alert('Invalid! Sum of columns should exceed 6');
                                 }
                                 }else if(e.data.columns == 5){
                                    if((parseInt(e.data.first_column) + parseInt(e.data.second_column) + parseInt(e.data.third_column) + parseInt(e.data.fourth_column) + parseInt(e.data.fifth_column)) < 7 ){
                                    editor.insertContent( 
                                    '[ultra_column_wrap]<br />'+ 
                                    '[ultra_column span="'+e.data.first_column+'"]Put your column 1 text[/ultra_column]<br />'+
                                    '[ultra_column span="'+e.data.second_column+'"]Put your column 2 text[/ultra_column]<br />'+
                                    '[ultra_column span="'+e.data.third_column+'"]Put your column 3 text[/ultra_column]<br />'+
                                    '[ultra_column span="'+e.data.fourth_column+'"]Put your column 4 text[/ultra_column]<br />'+
                                    '[ultra_column span="'+e.data.fifth_column+'"]Put your column 5 text[/ultra_column]<br />'+
                                    '[/ultra_column_wrap]<br />'
                                    );
                                    }else{
                                    alert('Invalid! Sum of columns should exceed 6');
                                 }
                                 }else if(e.data.columns == 6){
                                    if((parseInt(e.data.first_column) + parseInt(e.data.second_column) + parseInt(e.data.third_column) + parseInt(e.data.fourth_column) + parseInt(e.data.fifth_column) + parseInt(e.data.sixth_column)) < 7 ){
                                    editor.insertContent( 
                                    '[ultra_column_wrap]<br />'+ 
                                    '[ultra_column span="'+e.data.first_column+'"]Put your column 1 text[/ultra_column]<br />'+
                                    '[ultra_column span="'+e.data.second_column+'"]Put your column 2 text[/ultra_column]<br />'+
                                    '[ultra_column span="'+e.data.third_column+'"]Put your column 3 text[/ultra_column]<br />'+
                                    '[ultra_column span="'+e.data.fourth_column+'"]Put your column 4 text[/ultra_column]<br />'+
                                    '[ultra_column span="'+e.data.fifth_column+'"]Put your column 5 text[/ultra_column]<br />'+
                                    '[ultra_column span="'+e.data.sixth_column+'"]Put your column 6 text[/ultra_column]<br />'+
                                    '[/ultra_column_wrap]<br />'
                                    );
                                    }else{
                                       alert('Invalid! Sum of columns should exceed 6');
                                 }
                                 }
                           }
                        });
                     }
                  },
                  
                  
               ]
            },
            {
               text: 'Elements',
               menu: [
                  {
                     text: 'Social Icons',
                     onclick: function() {
                     editor.windowManager.open( {
                     title: 'Enter Social Icons',
                     body: [
                           {
                              type: 'textbox',
                              name: 'facebook',
                              label: 'Facebook Url',
                              value: 'http://facebook.com/',
                              minWidth: 300,
                           },
                           {
                              type: 'textbox',
                              name: 'twitter',
                              label: 'Twitter Url',
                              value: 'http://twitter.com/'
                           },
                           {
                              type: 'textbox',
                              name: 'gplus',
                              label: 'Google Plus Url',
                              value: 'https://plus.google.com/'
                           },
                           {
                              type: 'textbox',
                              name: 'skype',
                              label: 'Skype Url',
                              value: 'https://skype.com/'
                           },
                           {
                              type: 'textbox',
                              name: 'linkedin',
                              label: 'Linkedin Url',
                              value: 'http://www.linkedin.com'
                           },
                           {
                              type: 'textbox',
                              name: 'youtube',
                              label: 'Youtube Url',
                              value: 'http://www.youtube.com/'
                           }, 
                           {
                              type: 'textbox',
                              name: 'dribble',
                              label: 'Dribble Url',
                              value: 'https://dribbble.com/'
                           },  

                        ],
                        onsubmit: function( e ) {
                             editor.insertContent('[ultra_social facebook="'+e.data.facebook+'" twitter="'+e.data.twitter+'" gplus="'+e.data.gplus+'" skype="'+e.data.skype+'" linkedin="'+e.data.linkedin+'" youtube="'+e.data.youtube+'" dribble="'+e.data.dribble+'"]'); 
                        }
                       });
                     }
                  },
                  {
                     text: 'Toggle',
                     onclick: function() {
                     editor.windowManager.open( {
                     title: 'Toggle',
                     body: [
                           {
                              type: 'textbox',
                              name: 'toggle_heading',
                              label: 'Heading',
                              value: 'Your Heading',
                              minWidth: 400,
                           },
                           {
                              type: 'textbox',
                              name: 'toggle_detail',
                              label: 'Detail',
                              value: 'Write Detail Here',
                              multiline: true,
                              minWidth: 400,
                              minHeight: 150
                           },
                           {
                              type: 'listbox',
                              name: 'open_close',
                              label: 'Open/Close',
                              'values': [
                                 {text: 'Close', value: 'close'},
                                 {text: 'Open', value: 'open'}
                              ]
                           },
                        ],
                        onsubmit: function( e ) {
                             editor.insertContent('[ultra_toggle title="'+e.data.toggle_heading+'" status="'+e.data.open_close+'"]'+e.data.toggle_detail+'[/ultra_toggle]'); 
                        }
                       });
                     }
                  },
                  
                  {
                     text: 'Slider',
                     onclick: function() {
                     editor.windowManager.open( {
                     title: 'Slider Settings',
                     body: [
                           {
                              type: 'textbox',
                              name: 'no_of_img',
                              label: 'No of Image',
                              value: '4',
                              minWidth: 500,
                           },
                           {
                              type: 'textbox',
                              name: 'no_of_item',
                              label: 'No of Item to Show',
                              value: '1',
                              minWidth: 500,
                           },
                           {
                              type: 'listbox',
                              name: 'autoplay',
                              label: 'Autoplay',
                              'values': [
                                 {text: 'Yes', value: 'true'},
                                 {text: 'No', value: 'false'}
                              ]
                           },
                           {
                              type: 'listbox',
                              name: 'show_caption',
                              label: 'Show Caption',
                              'values': [
                                 {text: 'Yes', value: 'yes'},
                                 {text: 'No', value: 'no'}
                              ]
                           },
                           {
                              type: 'listbox',
                              name: 'link_image',
                              label: 'Link Image to Url',
                              'values': [
                                 {text: 'Yes', value: 'yes'},
                                 {text: 'No', value: 'no'}
                              ]
                           },
                           {
                              type: 'listbox',
                              name: 'open_link',
                              label: 'Open Link',
                              'values': [
                                 {text: 'In Same Tab', value: 'self'},
                                 {text: 'In Different Tab', value: 'blank'}
                              ]
                           },
                        ],
                        onsubmit: function( e ) {
                           var caption, link_image, open_link, item_no, autoplay, j;
                           item_no = e.data.no_of_item;
                           autoplay = e.data.autoplay;
                           editor.insertContent('[ultra_slider autoplay="'+autoplay+'" item="'+item_no+'"]');
                           for(i=1; i <= e.data.no_of_img; i++){
                              caption = e.data.show_caption=="yes" ? 'caption="Caption text'+i+'"' : '';
                              link_image = e.data.link_image=="yes" ? 'link="http://linkto'+i+'"' : '';
                              open_link = e.data.open_link=="self" ? 'target="_self"' : 'target="_blank"';

                              editor.insertContent(
                              '<br />[ultra_slide '+caption+' '+link_image+' '+open_link+']http://your_image_url'+i+'[/ultra_slide]'
                              ); 
                             }
                           editor.insertContent('<br />[/ultra_slider]');
                        }
                       });
                     }
                  },
                  {
                     text: 'Drop Caps',
                     onclick: function() {
                     editor.windowManager.open( {
                     title: 'Drop Caps Setting',
                     body: [
                           {
                              type: 'textbox',
                              name: 'letter',
                              label: 'Letter',
                              value: '',
                              minWidth: 300,
                           },
                           {
                              type: 'listbox',
                              name: 'style',
                              label: 'Drop Cap Style',
                              'values': [
                                 {text: 'Normal', value: 'ultra-normal'},
                                 {text: 'Square', value: 'ultra-square'}
                              ]
                           }
                        ],
                        onsubmit: function( e ) {
                           editor.insertContent('[ultra_dropcaps style="'+e.data.style+'"]'+e.data.letter+'[/ultra_dropcaps]'); 
                        }
                       });
                     }
                  },
                  {
                     text: 'Tagline Box',
                     onclick: function() {
                     editor.windowManager.open( {
                     title: 'Tagline Box Setting',
                     body: [
                           {
                              type: 'textbox',
                              name: 'ultra_tagline_text',
                              label: 'Tagline Text',
                              value: 'Enter you Tag Line text here',
                              multiline: true,
                              minWidth: 500,
                              minHeight: 150
                           },
                           {
                              type: 'listbox',
                              name: 'tag_box_style',
                              label: 'Tag Box Style',
                              'values': [
                                 {text: 'Border Box', value: 'ultra-all-border-box'},
                                 {text: 'Top Border Box', value: 'ultra-top-border-box'},
                                 {text: 'Left Border Box', value: 'ultra-left-border-box'},
                                 {text: 'Theme Background Box', value: 'ultra-bg-box'}
                              ]
                           }
                        ],
                        onsubmit: function( e ) {
                             editor.insertContent('[ultra_tagline_box tag_box_style="'+e.data.tag_box_style+'"]'+e.data.ultra_tagline_text+'[/ultra_tagline_box]'); 
                        }
                       });
                     }
                  },
                  {
                     text: 'Tab',
                     onclick: function() {
                     editor.windowManager.open( {
                     title: 'Tab Settings',
                     body: [
                           {
                              type: 'textbox',
                              name: 'no_of_tab',
                              label: 'No of Tabs',
                              value: '4',
                              minWidth: 300,
                           },
                           {
                              type: 'listbox',
                              name: 'tab_type',
                              label: 'Show Caption',
                              'values': [
                                 {text: 'Horizontal', value: 'horizontal'},
                                 {text: 'Vertical', value: 'vertical'}
                              ]
                           },
                        ],
                        onsubmit: function( e ) {
                           var j;
                           
                           editor.insertContent('[ultra_tab_group type="'+e.data.tab_type+'"]');
                           for(j=1; j <= e.data.no_of_tab; j++){
                              editor.insertContent(
                              '<br />[ultra_tab title="Title '+j+'"]Content '+j+'[/ultra_tab]'
                              ); 
                             }
                           editor.insertContent('<br />[/ultra_tab_group]');
                        }
                       });
                     }
                  },
                  {
                     text: 'List Style',
                     onclick: function() {
                     editor.windowManager.open( {
                     title: 'Select List style',
                     body: [
                           {
                              type: 'textbox',
                              name: 'no_of_list',
                              label: 'No of List Items',
                              value: '4',
                              minWidth: 300,
                           },
                           {
                              type: 'listbox',
                              name: 'list_type',
                              label: 'List Icon',
                              'values': [
                                 {text: 'Plus Icon', value: 'ultra-list1'},
                                 {text: 'Eye Icon', value: 'ultra-list2'},
                                 {text: 'Calender Icon', value: 'ultra-list3'},
                                 {text: 'Screen Icon', value: 'ultra-list4'},
                                 {text: 'Target Icon', value: 'ultra-list5'},
                                 {text: 'Pound Icon', value: 'ultra-list6'}
                              ]
                           },
                        ],
                        onsubmit: function( e ) {
                           var k;
                           
                           editor.insertContent('[ultra_list list_type="'+e.data.list_type+'"]');
                           for(k=1; k <= e.data.no_of_list; k++){
                              editor.insertContent(
                              '<br />[ultra_li]List Item '+k+'[/ultra_li]'
                              ); 
                             }
                           editor.insertContent('<br />[/ultra_list]');
                        }
                       });
                     }
                  }
               ]
            }
         ]
      });
   });
})();