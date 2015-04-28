$(function(){
    var clock = $('#clock');
    //定义数字数组0-9
    var digit_to_name = ['zero','one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
    //定义星期
    var weekday = ['周日','周一','周二','周三','周四','周五','周六'];
    var digits = {};
    //定义时分秒位置
    var positions = [
        'h1', 'h2', ':', 'm1', 'm2', ':', 's1', 's2'
    ];
    //构建数字时钟的时分秒
    var digit_holder = clock.find('.digits');
    $.each(positions, function(){
        if(this == ':'){
            digit_holder.append('<div class="dots">');
        }
        else{
            var pos = $('<div>');
            for(var i=1; i<8; i++){
                pos.append('<span class="d' + i + '">');
            }
            digits[this] = pos;
            digit_holder.append(pos);
        }
    });

    // 让时钟跑起来
    (function update_time(){
        //调用moment.js来格式化时间
        var now = moment().format("HHmmss");

        digits.h1.attr('class', digit_to_name[now[0]]);
        digits.h2.attr('class', digit_to_name[now[1]]);
        digits.m1.attr('class', digit_to_name[now[2]]);
        digits.m2.attr('class', digit_to_name[now[3]]);
        digits.s1.attr('class', digit_to_name[now[4]]);
        digits.s2.attr('class', digit_to_name[now[5]]);

        var date = moment().format("YYYY年MM月DD日");
        var week = weekday[moment().format('d')];
        $(".date").html(date + ' ' + week);


        // 每秒钟运行一次
        setTimeout(update_time, 1000);

    })();
});