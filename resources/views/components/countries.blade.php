<select class="form-control select2" name="country" id="country_id">
    @foreach($countries as $country)
    <option value="{{$country->id}}">{{$country->name}}</option>
    @endforeach
    <option value="{{$other->id}}">{{$other->name}}</option>
</select>




{{-- <option>الاكوادور</option>
    <option>الإمارات العربية المتحدة    </option>
    <option>الأرجنتين</option>
    <option>البحرين </option>
    <option>البرازيل</option>
    <option>البرتغال</option>
    <option>البوسنة والهرسك</option>
    <option>التشيك / جمهورية التشيك</option>
    <option>الجابون</option>
    <option>الجبل الأسود</option>
    <option>الجزائر </option>
    <option>الدنمارك</option>
    <option>السلفادور</option>
    <option>السنغال</option>
    <option>السودان </option>
    <option>السويد</option>
    <option>الصومال </option>
    <option>الصين</option>
    <option>العراق  </option>
    <option>القديسة لوسيا</option>
    <option>الكاميرون</option>
    <option>المغرب  </option>
    <option>المكسيك</option>
    <option>المملكة الأردنية الهاشمية   </option>
    <option>المملكة العربية السعودية    </option>
    <option>المملكة المتحدة</option>
    <option>النرويج</option>
    <option>النمسا</option>
    <option>النيجر</option>
    <option>الهند</option>
    <option>الولايات المتحدة الأمريكية</option>
    <option>اليابان</option>
    <option>اليمن   </option>
    <option>اليونان</option>
    <option>إريتريا</option>
    <option>إسبانيا</option>
    <option>إستونيا</option>
    <option>إقليم المحيط الهندي البريطاني</option>
    <option>إندونيسيا</option>
    <option>إيران</option>
    <option>إيسواتيني (سوازيلاند)</option>
    <option>إيطاليا</option>
    <option>أثيوبيا</option>
    <option>أذربيجان</option>
    <option>أرمينيا</option>
    <option>أستراليا</option>
    <option>أفغانستان</option>
    <option>ألبانيا</option>
    <option>ألمانيا</option>
    <option>أنتيغوا وبربودا</option>
    <option>أندورا</option>
    <option>أنغولا</option>
    <option>أوروغواي</option>
    <option>أوزبكستان</option>
    <option>أوغندا</option>
    <option>أوكرانيا</option>
    <option>أيرلندا</option>
    <option>أيسلندا</option>
    <option>بابوا غينيا الجديدة</option>
    <option>باراغواي</option>
    <option>باكستان</option>
    <option>بالاو</option>
    <option>بربادوس</option>
    <option>بروناي</option>
    <option>بلجيكا</option>
    <option>بلغاريا</option>
    <option>بليز</option>
    <option>بنغلاديش</option>
    <option>بنما</option>
    <option>بنين</option>
    <option>بوتان</option>
    <option>بوتسوانا</option>
    <option>بوركينا فاسو</option>
    <option>بوروندي</option>
    <option>بولندا</option>
    <option>بوليفيا</option>
    <option>بيرو</option>
    <option>بيلاروسيا</option>
    <option>تايلاند</option>
    <option>تايوان.</option>
    <option>تركمانستان</option>
    <option>تركيا.</option>
    <option>ترينداد وتوباغو</option>
    <option>تشاد</option>
    <option>تشيلي</option>
    <option>تنزانيا</option>
    <option>توجو</option>
    <option>توفالو</option>
    <option>تونس    </option>
    <option>تونغا</option>
    <option>تيمور – ليشتي / تيمور الشرقية</option>
    <option>جامايكا</option>
    <option>جزر البهاما</option>
    <option>جزر القمر   </option>
    <option>جزر المالديف</option>
    <option>جزر سليمان</option>
    <option>جزر مارشال</option>
    <option>جمهورية افريقيا الوسطى</option>
    <option>جمهورية الدومنيكان</option>
    <option>جمهورية الكونغو</option>
    <option>جمهورية الكونغو الديموقراطية</option>
    <option>جنوب السودان</option>
    <option>جنوب أفريقيا</option>
    <option>جورجيا</option>
    <option>جيبوتي  </option>
    <option selected> الكويت </option>
    <option>دومينيكا</option>
    <option>رواندا</option>
    <option>روسيا.</option>
    <option>رومانيا</option>
    <option>زامبيا</option>
    <option>زيمبابوي</option>
    <option>ساحل العاج / جمهورية كوت ديفوار</option>
    <option>ساموا</option>
    <option>سان مارينو</option>
    <option>سانت فنسنت وجزر غرينادين</option>
    <option>سانت كيتس ونيفيس</option>
    <option>ساو تومي وبرينسيبي</option>
    <option>سلطنة عمان  </option>
    <option>سلوفاكيا</option>
    <option>سلوفينيا</option>
    <option>سنغافورة</option>
    <option>سوريا</option>
    <option>سورينام</option>
    <option>سويسرا</option>
    <option>سيرا ليون</option>
    <option>سيريلانكا</option>
    <option>سيشيل</option>
    <option>صربيا</option>
    <option>طاجيكستان</option>
    <option>غامبيا</option>
    <option>غانا</option>
    <option>غرينادا</option>
    <option>غواتيمالا</option>
    <option>غيانا</option>
    <option>غينيا</option>
    <option>غينيا الإستوائية</option>
    <option>غينيا بيساو</option>
    <option>فانواتو</option>
    <option>فرنسا</option>
    <option>فلسطين  </option>
    <option>فنزويلا</option>
    <option>فنلندا</option>
    <option>فيتنام</option>
    <option>فيجي</option>
    <option>فيلبيني</option>
    <option>قبرص.</option>
    <option>قطر </option>
    <option>قيرغيزستان</option>
    <option>كابو فيردي/ الرأس الأخضر</option>
    <option>كازاخستان.</option>
    <option>كرواتيا</option>
    <option>كمبوديا</option>
    <option>كندا</option>
    <option>كوبا</option>
    <option>كوريا الجنوبية.</option>
    <option>كوريا الشمالية (جمهورية كوريا الشعبية الديمقراطية)</option>
    <option>كوستا ريكا</option>
    <option>كولومبيا</option>
    <option>كيريباتي</option>
    <option>كينيا</option>
    <option>لاتفيا</option>
    <option>لاوس</option>
    <option>لبنان   </option>
    <option>لوكسمبورغ</option>
    <option>ليبيا   </option>
    <option>ليبيريا</option>
    <option>ليتوانيا</option>
    <option>ليختنشتاين</option>
    <option>ليسوتو</option>
    <option>ماكاو.</option>
    <option>مالطا</option>
    <option>مالي</option>
    <option>ماليزيا</option>
    <option>مدغشقر</option>
    <option>مدينة الفاتيكان (الكرسي الرسولي)</option>
    <option>مصر </option>
    <option>مقدونيا الشمالية</option>
    <option>ملاوي</option>
    <option>منغوليا</option>
    <option>موريتانيا   </option>
    <option>موريشيوس</option>
    <option>موزمبيق</option>
    <option>مولدوفا</option>
    <option>موناكو</option>
    <option>ميانمار (بورما سابقًا)</option>
    <option>ميكرونيزيا</option>
    <option>ناميبيا</option>
    <option>ناورو</option>
    <option>نيبال</option>
    <option>نيجيريا</option>
    <option>نيكاراغوا</option>
    <option>نيوزيلندا</option>
    <option>هايتي</option>
    <option>هندوراس</option>
    <option>هنغاريا</option>
    <option>هولندا</option> --}}