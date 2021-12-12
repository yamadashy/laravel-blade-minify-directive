<html lang="">
<header>

</header>
<body>
<section>
    <div>
        <!-- comment will not remove -->
        <div>test1</div>
        @minify
        <!-- comment will remove -->
        <div>test2</div>
        <div>test3</div>
        @endminify
        <div>
            <div>
                <span>test4</span>
            </div>
            @minify
            <div>
                test5
            </div>
            @endminify
        </div>
        <div></div>
    </div>

    @minify
    <div class="minify">
        <div>
            <div>test1</div>
            <div>
                <span>test2</span>
            </div>
            <div>
                <div>
                    <div>test3</div>
                </div>
            </div>
            <div class="test1">
                test4
            </div>
        </div>
    </div>
    @endminify
</section>
</body>
</html>
