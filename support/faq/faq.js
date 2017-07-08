$(document).ready(function () {
    $("#header").load("/header.html");
    $("#footer").load("/footer.html");
    $(function () {
        $('.carousel').carousel({
            interval: 2000
        });
    });

    var questions = [
        {
            "q": "What is Fixcell?",
            "a": "Fixcell is India&apos;s largest and most trusted smartphone & tablet service network. We fix smartphones/tablets of all brands & make with the added convenience of free pickup and delivery."
        },
        {
            "q": "How does Fixcell work?",
            "a": "Place a service request through the Repairs section or call us at +91-9949360232. We visit you, take your mobile device, diagnose it, fix it in your presence - making the process completely hassle free for you."
        },
        {
            "q": "What are the cities Fixcell operates in?",
            "a": "We have office in  Hyderabad, we provide door step repair service."
        },
        {
            "q": "How do I place a service request at Fixcell?",
            "a": "Visit Repairs section, select your model and issue and checkout"
        },
        {
            "q": "How much does Fixcell charge for its repair service? ",
            "a": "Fixcell charges Rs. 249/- for diagnosis. This is collected when the technician reaches your home.The price you see on the website is inclusive of this service charge and this gets adjusted in the final invoice. In case of any additional charges, customer would be intimated before mobile servicing is begun."
        },

        {
            "q": "Is there a service charge on Fixcell warranty repair?",
            "a": "There is no service charge on concerns/complaints regarding repair that are raised within 3 days of delivery of product. However, we charge a nominal service fee of Rs.249 as service/labor charge if the complaint is raised after 3 days post-delivery."
        },
        {
            "q": "How safe is my mobile/tablet with Fixcell? ",
            "a": "Fixcell guarantees the safety of your electronic devices by providing security insurance and undertaking blanket responsibility against any possible theft/loss caused while the mobile device is in its possession. However please note physical damage to screen often results damage to other components (sensor, motherboard, etc.) and Fixcell won't be held responsible for issues which are discovered during the process of repair. Repair/diagnosis of device might result in minor wear & tear, hence the device might not be returned in as-is state."
        }
    ];
    $(function () {
        for (var i = 0; i < questions.length; i++) {
            var prev = $("#accordion").html();
            var next = '<div class="panel panel-default"><a data-toggle="collapse" data-parent="#accordion" href="#collapse' + i + '"><div class="panel-heading"><h4 class="panel-title">' +
                questions[i]['q'] + '</h4></div></a><div id="collapse' + i + '" class="panel-collapse collapse "><div class="panel-body">' + questions[i]['a'] + '</div></div></div>';
            $("#accordion").html(prev + next);
        }
    });
});