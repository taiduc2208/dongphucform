// Dữ liệu slider
const sliderData = [
  { img: "https://www.meguro.ac.jp/websys2/wp-content/uploads/2023/07/51A4905-scaled-e1689984006736.jpg", caption: "" },
  { img: "https://www.meguro.ac.jp/websys2/wp-content/uploads/2023/11/男子正装-1.png", caption: "男子生徒の正装です" },
  { img: "https://www.meguro.ac.jp/websys2/wp-content/uploads/2023/11/正装女子-1.png", caption: "女子生徒の正装です" },
  { img: "https://www.meguro.ac.jp/websys2/wp-content/uploads/2023/11/正装男子紺ベスト.png", caption: "男子コーディネート（セーター）" },
  { img: "https://www.meguro.ac.jp/websys2/wp-content/uploads/2023/11/正装女子白シャツ.png", caption: "女子コーディネート（ネクタイ・白ブラウス・ハイソックス）" },
  { img: "https://www.meguro.ac.jp/websys2/wp-content/uploads/2023/11/女子OPSKサックス.png", caption: "女子コーディネート（青リボン・青ブラウス・青スカート・ハイソックス）" },
  { img: "https://www.meguro.ac.jp/websys2/wp-content/uploads/2023/11/女子OPSKピンク.png", caption: "女子コーディネート（ピンクリボン・ピンクブラウス・ピンクスカート・ハイソックス）" },
  { img: "https://www.meguro.ac.jp/websys2/wp-content/uploads/2023/11/女子OPSK紺ベスト.png", caption: "女子コーディネート(青リボン・青ブラウス・青スカート・セーター・ハイソックス)" },
  { img: "https://www.meguro.ac.jp/websys2/wp-content/uploads/2024/04/女子スラックス正装正面.png", caption: "女子コーディネート(ネクタイ・青ブラウス・女子スラックス)" },
  { img: "https://www.meguro.ac.jp/websys2/wp-content/uploads/2023/11/ネクタイ・リボン.png", caption: "ネクタイは青、リボンは正リボン（青ライン）とサブリボン（赤ライン）の2種類があります" },
];

const $mainSlider = document.querySelector(".js-seifukuMainSlider");
const $thumbSlider = document.querySelector(".js-seifukuThumbSlider");

// Tạo slides
sliderData.forEach(item => {
  // Main slider
  const mainSlide = document.createElement("div");
  mainSlide.innerHTML = `
    <div>
      <div class="slider__item" style="width: 100%; display: inline-block;">
        <a class="flex justify-center" href="${item.img}" data-fancybox="groupseifuku" data-caption="${item.caption}">
          <img src="${item.img}" alt="${item.caption}" width="560" loading="lazy">
        </a>
        ${item.caption ? `<p>${item.caption}</p>` : ""}
      </div>
    </div>
  `;
  $mainSlider.appendChild(mainSlide);

  // Thumb slider
  const thumbSlide = document.createElement("div");
  thumbSlide.innerHTML = `
    <div>
      <div class="slider__item" style="width: 100%; display: inline-block;">
        <img class="w-full h-auto" src="${item.img}" alt="${item.caption}" width="62" loading="lazy">
      </div>
    </div>
  `;
  $thumbSlider.appendChild(thumbSlide);
});

// Init Slick sliders
$($mainSlider).slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: true,
  asNavFor: ".js-seifukuThumbSlider",
  adaptiveHeight: false,   // fix height
  infinite: false,
  prevArrow: ".seifuku__mainslider__arrow--prev",
  nextArrow: ".seifuku__mainslider__arrow--next",
});

$($thumbSlider).slick({
  slidesToShow: 8,
  slidesToScroll: 1,
  asNavFor: ".js-seifukuMainSlider",
  focusOnSelect: true,
  infinite: false,
  vertical: true, // mặc định dọc
  prevArrow: ".seifuku__thumbslider__arrow--prev",
  nextArrow: ".seifuku__thumbslider__arrow--next",
  responsive: [
    {
      breakpoint: 1024, // màn hình nhỏ hơn 1024px
      settings: {
        vertical: false, // chuyển ngang
        slidesToShow: 5,
      },
    },
    {
      breakpoint: 751, // màn hình nhỏ hơn 751px
      settings: {
        vertical: false,
        slidesToShow: 6,
      },
    },
  ],
});

// Init Fancybox 4
Fancybox.bind("[data-fancybox='groupseifuku']", {});
