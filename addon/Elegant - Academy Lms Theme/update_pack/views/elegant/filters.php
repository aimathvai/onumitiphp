<aside class="col-lg-3" id="sidebar">
  <div id="filters_col"> <a data-toggle="collapse" href="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters" id="filters_col_bt">Filters </a>
    <div class="collapse show" id="collapseFilters">
      <div class="filter_type">
        <h6><?php echo site_phrase('categories'); ?></h6>
        <ul>
          <li class="">
            <div class="">
              <input type="radio" id="category_all" name="sub_category" class="categories custom-radio" value="all" onclick="filter(this)" <?php if($selected_category_id == 'all') echo 'checked'; ?>>
              <label for="category_all"><?php echo site_phrase('all_category'); ?></label>
            </div>
          </li>
          <?php
          $counter = 1;
          $total_number_of_categories = $this->db->get('category')->num_rows();
          $categories = $this->crud_model->get_categories()->result_array();
          foreach ($categories as $category): ?>
          <li class="">
            <div class="<?php if ($counter > $number_of_visible_categories): ?> hidden-categories hidden <?php endif; ?>">
              <input type="radio" id="category-<?php echo $category['id'];?>" name="sub_category" class="categories custom-radio" value="<?php echo $category['slug']; ?>" onclick="filter(this)" <?php if($selected_category_id == $category['id']) echo 'checked'; ?>>
              <label for="category-<?php echo $category['id'];?>"><?php echo $category['name']; ?></label>
            </div>
          </li>
          <!-- <span class="parent-category <?php if ($counter > $number_of_visible_categories): ?> hidden-categories hidden <?php endif; ?>"><?php echo $category['name']; ?></span> -->
          <?php foreach ($this->crud_model->get_sub_categories($category['id']) as $sub_category):
            $counter++; ?>
            <li class="ml-3">
              <div class="<?php if ($counter > $number_of_visible_categories): ?> hidden-categories hidden <?php endif; ?>">
                <input type="radio" id="sub_category-<?php echo $sub_category['id'];?>" name="sub_category" class="categories custom-radio" value="<?php echo $sub_category['slug']; ?>" onclick="filter(this)" <?php if($selected_category_id == $sub_category['id']) echo 'checked'; ?>>
                <label for="sub_category-<?php echo $sub_category['id'];?>"><?php echo $sub_category['name']; ?></label>
              </div>
            </li>
          <?php endforeach; ?>
        <?php endforeach; ?>
      </ul>
      <a href="javascript::" id = "city-toggle-btn" onclick="showToggle(this, 'hidden-categories')" class="show-more-less"><?php echo $total_number_of_categories > $number_of_visible_categories ? site_phrase('show_more') : ""; ?></a>
    </div>

    <div class="filter_type">
      <div class="form-group">
        <h6><?php echo site_phrase('price'); ?></h6>
        <ul>
          <li>
            <div class="">
              <input type="radio" id="price_all" name="price" class="prices custom-radio" value="all" onclick="filter(this)" <?php if($selected_price == 'all') echo 'checked'; ?>>
              <label for="price_all"><?php echo site_phrase('all'); ?></label>
            </div>
            <div class="">
              <input type="radio" id="price_free" name="price" class="prices custom-radio" value="free" onclick="filter(this)" <?php if($selected_price == 'free') echo 'checked'; ?>>
              <label for="price_free"><?php echo site_phrase('free'); ?></label>
            </div>
            <div class="">
              <input type="radio" id="price_paid" name="price" class="prices custom-radio" value="paid" onclick="filter(this)" <?php if($selected_price == 'paid') echo 'checked'; ?>>
              <label for="price_paid"><?php echo site_phrase('paid'); ?></label>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <div class="filter_type">
      <h6><?php echo site_phrase('level'); ?></h6>
      <ul>
        <li>
          <div class="">
            <input type="radio" id="all" name="level" class="level custom-radio" value="all" onclick="filter(this)" <?php if($selected_level == 'all') echo 'checked'; ?>>
            <label for="all"><?php echo site_phrase('all'); ?></label>
          </div>
          <div class="">
            <input type="radio" id="beginner" name="level" class="level custom-radio" value="beginner" onclick="filter(this)" <?php if($selected_level == 'beginner') echo 'checked'; ?>>
            <label for="beginner"><?php echo site_phrase('beginner'); ?></label>
          </div>
          <div class="">
            <input type="radio" id="advanced" name="level" class="level custom-radio" value="advanced" onclick="filter(this)" <?php if($selected_level == 'advanced') echo 'checked'; ?>>
            <label for="advanced"><?php echo site_phrase('advanced'); ?></label>
          </div>
          <div class="">
            <input type="radio" id="intermediate" name="level" class="level custom-radio" value="intermediate" onclick="filter(this)" <?php if($selected_level == 'intermediate') echo 'checked'; ?>>
            <label for="intermediate"><?php echo site_phrase('intermediate'); ?></label>
          </div>
        </li>
      </ul>
    </div>

    <div class="filter_type">
      <h6><?php echo site_phrase('language'); ?></h6>
      <ul>
        <li>
          <div class="">
            <input type="radio" id="all_language" name="language" class="languages custom-radio" value="<?php echo 'all'; ?>" onclick="filter(this)" <?php if($selected_language == "all") echo 'checked'; ?>>
            <label for="<?php echo 'all_language'; ?>"><?php echo site_phrase('all'); ?></label>
          </div>
        </li>
        <?php
        $languages = $this->crud_model->get_all_languages();
        foreach ($languages as $language): ?>
        <li>
          <div class="">
            <input type="radio" id="language_<?php echo $language; ?>" name="language" class="languages custom-radio" value="<?php echo $language; ?>" onclick="filter(this)" <?php if($selected_language == $language) echo 'checked'; ?>>
            <label for="language_<?php echo $language; ?>"><?php echo ucfirst($language); ?></label>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="filter_type">
    <h6><?php echo site_phrase('ratings'); ?></h6>
    <ul>

      <li>
        <div class="">
          <input type="radio" id="all_rating" name="rating" class="ratings custom-radio" value="<?php echo 'all'; ?>" onclick="filter(this)" <?php if($selected_rating == "all") echo 'checked'; ?>>
          <label for="all_rating"><?php echo site_phrase('all'); ?></label>
        </div>
      </li>
      <?php for($i = 1; $i <= 5; $i++): ?>
        <li>
          <div class="">
            <input type="radio" id="rating_<?php echo $i; ?>" name="rating" class="ratings custom-radio" value="<?php echo $i; ?>" onclick="filter(this)" <?php if($selected_rating == $i) echo 'checked'; ?>>
            <label for="rating_<?php echo $i; ?>">
              <?php for($j = 1; $j <= $i; $j++): ?>
                <span class="rating"><i class="icon_star voted"></i></span>
              <?php endfor; ?>
              <?php for($j = $i; $j < 5; $j++): ?>
                <span class="rating"><i class="icon_star"></i></span>
              <?php endfor; ?>
            </label>
          </div>
        </li>
      <?php endfor; ?>
    </ul>
  </div>
  <!--/collapse -->
</div>
</div>
<!--/filters col-->
</aside>
