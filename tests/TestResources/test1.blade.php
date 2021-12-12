<html lang="">
<header>

</header>
<body>
@minify
<section>
    <div>
        <div>test1</div>
        <div>test2</div>
        <div>test3</div>
        <!-- comment will remove -->
        <div>
            <div>
                <span>test4</span>
            </div>
            <div>
                test5
            </div>
        </div>
        <div></div>
    </div>

    <div>
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
            <div class="test">
                test4
            </div>
        </div>
    </div>
</section>
@endminify
</body>
</html>
