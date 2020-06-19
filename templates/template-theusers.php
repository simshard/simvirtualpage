<?php

/**
 * Users endpoint page
 *
 * Template to display users endpoint  virtual page
 * php version 7.2.10
 *
 * @category     Sim_Virtual_Page_Plugin
 * @package      Wp-plugin
 * @author       Sim <simon.kember@blueyonder.co.uk>
 * @license      http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link         https://www.linkedin.com/in/simon-kember-923551a7/
 * @date-written 15 May 2020
 * @date-revised 1 Jun 2020
 *
 */

declare(strict_types=1);

namespace simVirtualpage\templates;

get_header();
the_post();
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <article id="post-<?php the_ID(); ?>" class="hentry">
            <header class="entry-header">
                <h2 class="entry-title">Users</h2>
            </header><!-- .entry-header -->

            <div class="entry-content">
                <div id="user-list">
                    <table class="users-list">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Username</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $userdata = $simVirtualpage->doRemoteApiCall();
                        if (null ===  $userdata) {
                            echo 'There was a problem communicating with the API..';
                        }
                        echo '<tr>';
                        foreach ($userdata as $user) :
                            echo '<td><a class="userlink" href="javascript:void(0);"
                             user="' . esc_attr($user->id) . '"  >' . esc_attr($user->id) . '</a></td>';
                            echo '<td><a class="userlink" href="javascript:void(0);"
                             user="' . esc_attr($user->id) . '">' . esc_attr($user->name) . '</a></td>';
                            echo '<td><a class="userlink" href="javascript:void(0);"
                             user="' . esc_attr($user->id) . '">' . esc_attr($user->username) . '</a></td>';
                            echo'</tr>';
                        endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>
                <div id="loader">
                    <div id="cG">
                        <div id="cG_1" class="cG"></div>
                        <div id="cG_2" class="cG"></div>
                        <div id="cG_3" class="cG"></div>
                        <div id="cG_4" class="cG"></div>
                        <div id="cG_5" class="cG"></div>
                        <div id="cG_6" class="cG"></div>
                        <div id="cG_7" class="cG"></div>
                        <div id="cG_8" class="cG"></div>
                    </div>
                </div>
                <h5>User data</h5>
                <div id="user-data">
                </div>
            </div>
        </article>
    </main><!-- .site-main -->
</div><!-- .content-area -->
<?php
    get_footer();
?>