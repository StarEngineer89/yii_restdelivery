{if !isset($content_only) || !$content_only}
            {if $page_name != 'index'}
					</div><!-- #center_column -->
					{if isset($right_column_size) && !empty($right_column_size)}
						<div id="right_column" class="col-xs-12 col-sm-{$right_column_size|intval} column">{$HOOK_RIGHT_COLUMN}</div>
					{/if}
					</div><!-- .row -->
				</div><!-- #columns -->
			</div><!-- .columns-container -->
        {/if}
		</div><!--main_right-->
        </div><!-- #page -->
        {if isset($HOOK_FOOTER)}
    		<!-- Footer -->
            <div class="footer-wrapper">
				<footer id="footer"  class="container">
					{$HOOK_FOOTER}
				</footer>
            </div>
    	{/if}
{/if}
{include file="$tpl_dir./global.tpl"}
	</body>
</html>