<div class="sidebar_expand_collapse">
	<i class="fa fa-bars" aria-hidden="true"></i>
</div><div id="sidebar">
	<div class="navigation">Navigation</div>
	<ul>
		<li <?=($this->page=="dashboard")?"class='current'":"";?>>
			<a href="#"><i class="fa fa-tachometer" aria-hidden="true"></i><span>Dashboard</span></a>
		</li>
		<li <?=($this->page=="bots")?"class='current'":"";?>>
			<a href="#"><i class="fa fa-android" aria-hidden="true"></i><span>Bots</span></a>
			<ul>
				<li>
					<a href="#"><i class="fa fa-cogs" aria-hidden="true"></i><span>Manage Bots</span></a>
				</li>
				<li>
					<a href="#"><i class="fa fa-plus" aria-hidden="true"></i></span>Create New Bots</span></a>
				</li>
			</ul>
		</li>
		<li <?=($this->page=="groups")?"class='current'":"";?>>
			<a href="#"><i class="fa fa-users" aria-hidden="true"></i><span>Groups</span></a>
			<ul>
				<li>
					<a href="#"><i class="fa fa-cogs" aria-hidden="true"></i><span>Manage Groups</span></a>
				</li>
				<li>
					<a href="#"><i class="fa fa-plus" aria-hidden="true"></i></span>Create New Group</span></a>
				</li>
			</ul>
		</li>
		<li <?=($this->page=="routines")?"class='current'":"";?>>
			<a href="#"><i class="fa fa-list-ol" aria-hidden="true"></i><span>Routines</span></a>
			<ul>
				<li>
					<a href="#"><i class="fa fa-cogs" aria-hidden="true"></i><span>Manage Routines</span></a>
				</li>
				<li>
					<a href="#"><i class="fa fa-plus" aria-hidden="true"></i></span>Create New Routine</span></a>
				</li>
			</ul>
		</li>
	</ul>
</div>