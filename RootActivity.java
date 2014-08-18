package com.etb_lab.my_textbooks;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.Calendar;
import java.util.Collections;
import java.util.GregorianCalendar;
import java.util.List;
import java.util.Timer;
import java.util.TimerTask;

import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences.Editor;
import android.content.res.Configuration;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.support.v4.app.ActionBarDrawerToggle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.widget.DrawerLayout;
import android.view.GestureDetector;
import android.view.GestureDetector.OnGestureListener;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.etb_lab.api2.AvatarSender;
import com.etb_lab.api2.model.CropParams;
import com.etb_lab.my_textbooks.ContentActivity.DrawerFlingDetector;
import com.etb_lab.my_textbooks.dataproviders.DataProvider.OnLogoutListener;
import com.etb_lab.my_textbooks.dataproviders.SessionManager;
import com.etb_lab.my_textbooks.dataproviders.SimpleDataProvider;
import com.etb_lab.my_textbooks.dialogs.JournalGradeAttendanceDialog;
import com.etb_lab.my_textbooks.dialogs.SearchFilterDialogFragment.OnSearchFilterItemSelectedListener;
import com.etb_lab.my_textbooks.fragments.BigJournalFragment;
import com.etb_lab.my_textbooks.fragments.BookshelfFragment;
import com.etb_lab.my_textbooks.fragments.DiaryFragment;
import com.etb_lab.my_textbooks.fragments.EventsFragment;
import com.etb_lab.my_textbooks.fragments.PersonalAccountFragment;
import com.etb_lab.my_textbooks.fragments.ScheduleFragment;
import com.etb_lab.my_textbooks.fragments.SettingsFragment;
import com.etb_lab.my_textbooks.fragments.ShopFragment.FilterType;
import com.etb_lab.my_textbooks.fragments.StatisticsFragment;
import com.etb_lab.my_textbooks.interfaces.JournalUpdate;
import com.etb_lab.my_textbooks.model.Avatar;
import com.etb_lab.my_textbooks.utils.ABInflater;
import com.etb_lab.my_textbooks.utils.ABInflater.ActivityAwareBottomActionBarDelegate;
import com.etb_lab.my_textbooks.utils.ABInflater.BottomActionBarDelegate;
import com.etb_lab.my_textbooks.utils.AvatarMemoryCache;
import com.etb_lab.my_textbooks.utils.DownloaderFacade;
import com.etb_lab.my_textbooks.utils.NotificationManager;
import com.etb_lab.my_textbooks.utils.NotificationManager.Event;
import com.etb_lab.my_textbooks.utils.UIHelper;
import com.soundcloud.android.crop.Crop;

/**
 * User: Tumanov Date: 2/6/14 Time: 5:56 PM Root activity with action bar and
 * navigation drawer. Can contain one of the main fragment: personal room,
 * bookshelf, schedule, diary, statistics or settings.
 */
public class RootActivity extends DialogDisplayerActivity implements OnClickListener, android.content.DialogInterface.OnClickListener,
		OnSearchFilterItemSelectedListener, OnLogoutListener, JournalUpdate {
	public static final String KEY_SELECTED_ITEM = "KEY_SELECTED_ITEM";
	private static final int NETWORK_CHECK_STEP = 15000;

	public static final int REQUEST_CODE_TAKE_PHOTO = 0;
    public static final int GRADE_REQUEST_TAKE_A_PICTURE = 5106;
    public static final int GRADE_REQUEST_CHOOSE_FROM_GALLERY = 5105;

    private DrawerLayout _drawerLayout;
	private ActionBarDrawerToggle _drawerToggle;
	private LinearLayout _leftDrawer;
	private ListView _navigationItems;
	private List<NavigationItemModel> _items;
	private int _currentPage;
	private SimpleDataProvider dataProvider = SimpleDataProvider.getInstance();
	private DownloaderFacade downloaderFacade = DownloaderFacade.getInstance();

	private OnGestureListener gestureListener; // = new DrawerFlingDetector();
	private GestureDetector gestureDetector; // = new
												// GestureDetector(App.getInstance(),
												// listener);
	private Timer _offlineTimer = null;

	public interface ActionBarInflater {
		public void inflateActionBar(View actionBarCustomView);
	}

	private BottomActionBarDelegate bottomActionBarDelegate = new ActivityAwareBottomActionBarDelegate(this) {

		@Override
		public void moveToBottom(ViewGroup left, ViewGroup right, ViewGroup bottom) {
			assert false;
		}

		@Override
		public String getLongestTitlePossible() {
			assert false;
			return null;
		}

	};
	private ABInflater inflater = new ABInflater(bottomActionBarDelegate);

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.root);

		if (savedInstanceState == null) {
			PersonalAccountFragment.setJoinRoomHandler(this);
		}
		_drawerLayout = (DrawerLayout) findViewById(R.id.drawer_layout);
		_drawerLayout.setScrimColor(0x00FFFFFF);
		_drawerToggle = new ActionBarDrawerToggle(this, _drawerLayout, R.drawable.ic_drawer, R.string.drawer_open, R.string.drawer_close);
		_drawerLayout.setDrawerListener(_drawerToggle);
		inflater.addCustomActionbar(this);

		_leftDrawer = (LinearLayout) findViewById(R.id.left_drawer);
		gestureListener = new DrawerFlingDetector(_drawerLayout);
		gestureDetector = new GestureDetector(App.getInstance(), gestureListener);

		generateNavigationItems();
		
		if (_currentPage == -1) {
			_currentPage = PreferenceManager.getDefaultSharedPreferences(this).getInt(KEY_SELECTED_ITEM, 0);
		}
		
		if (_currentPage + 1 > _items.size())
			_currentPage = 0;
		if (savedInstanceState == null) {
			selectItem(_currentPage);
		} else {
			inflater.addCustomViewLeftButton(this, _items.get(_currentPage).barIconId, R.id.iv_book);
		}

		dataProvider.setOnLogoutListener(this);
		getSupportActionBar().getCustomView().post(new Runnable() {

			@Override
			public void run() {
				actionbarHeight = getSupportActionBar().getCustomView().getHeight();
			}
		});

	}

	@Override
	protected void onResume() {
		super.onResume();
		if (LoginActivity.isOffline(this)) {
			if (_offlineTimer != null)
				_offlineTimer.cancel();
			_offlineTimer = new Timer();
			_offlineTimer.schedule(new TimerTask() {
				@Override
				public void run() {
					checkNetwork();
				}
			}, NETWORK_CHECK_STEP);
		}
	}

	private void generateNavigationItems() {
        NavigationItemModel personalRoom = new NavigationItemModel(R.drawable.am_account, R.drawable.am_account_sel, R.drawable.tb_appmenu_green,
                R.string.personal_room_caption, R.color.personal_accent_selector, R.id.account);
        NavigationItemModel textBooks = new NavigationItemModel(R.drawable.am_books, R.drawable.am_books_sel, R.drawable.tb_appmenu_blue,
                R.string.bookshelf_caption, R.color.bookshelf_accent_selector, R.id.bookshelf);
		NavigationItemModel statistic = new NavigationItemModel(R.drawable.am_statistics, R.drawable.am_statistics_sel, R.drawable.tb_appmenu_purple,
				R.string.statistic_caption, R.color.statistic_accent_selector, R.id.statistics);
		NavigationItemModel settings = new NavigationItemModel(R.drawable.am_settings, R.drawable.am_settings_sel, R.drawable.tb_appmenu_gray,
				R.string.settings_caption, R.color.settings_accent_selector, R.id.settings);
        NavigationItemModel events = new NavigationItemModel(R.drawable.am_schedule, R.drawable.am_schedule_sel,
                R.drawable.tb_appmenu_orange, R.string.schedule_caption, R.color.schedule_accent_selector, R.id.schedule);
        NavigationItemModel diary = new NavigationItemModel(R.drawable.am_diary, R.drawable.am_diary_sel, R.drawable.tb_appmenu_red,
                R.string.diary_caption, R.color.diary_accent_selector, R.id.diary);
        NavigationItemModel journal = new NavigationItemModel(R.drawable.am_diary, R.drawable.am_diary_sel, R.drawable.tb_appmenu_red,
                R.string.journal_caption, R.color.diary_accent_selector, R.id.journal);
        NavigationItemModel order = new NavigationItemModel(R.drawable.am_order, R.drawable.am_order_sel, R.drawable.tb_appmenu_cyan,
                R.string.request_caption, R.color.requests_accent_selector, R.id.requests);

		_items = new ArrayList<RootActivity.NavigationItemModel>();
		_items.add(personalRoom);
		if (dataProvider != null && dataProvider.getUserType() != null) {
			switch (dataProvider.getUserType()) {
			case ADMIN:
                Collections.addAll(_items, textBooks);
				if (!LoginActivity.isOffline(this)) {
					if (dataProvider.getUser().getClasses() != null && dataProvider.getUser().getClasses().size() > 0)
//						_items.add(statistic);
					_items.add(order);
				}
				_items.add(settings);
				break;
			case PARENT:
                Collections.addAll(_items, events, diary);
                if (dataProvider.getUser().getDisciplines() != null && dataProvider.getUser().getDisciplines().size() != 0) {
//                    _items.add(statistic);
                }
                break;
			case PUPIL:
                Collections.addAll(_items, textBooks, events, diary);
				if (dataProvider.getUser().getDisciplines() != null && dataProvider.getUser().getDisciplines().size() != 0) {
//					_items.add(statistic);
				}
				_items.add(settings);
				break;
			case DEPUTY:
			case TEACHER:
                Collections.addAll(_items, textBooks, events, journal);
				if (!LoginActivity.isOffline(this) && dataProvider.getUser().getClasses() != null && dataProvider.getUser().getClasses().size() > 0) {
//					_items.add(statistic);
				}
				_items.add(settings);
				break;
			}
		}
		_navigationItems = (ListView) findViewById(R.id.navigation_items);
		navigationDrawerAdapter = new NavigationDrawerAdapter(this, _items);
		_navigationItems.setAdapter(navigationDrawerAdapter);
		_navigationItems.setOnItemClickListener(new ListView.OnItemClickListener() {
			@Override
			public void onItemClick(AdapterView parent, View view, int position, long id) {
				selectItem(position);
			}
		});
	}

	@Override
	protected void onDestroy() {
		// удалять только себя
		if (dataProvider.getOnLogoutListener() == this) {
			dataProvider.setOnLogoutListener(null);
		}
		// downloaderFacade.unregisterComponentLoadingListener(this);
		// downloaderFacade.unregisterOnComponentRemoveListener(this);
		super.onDestroy();
	}

	@Override
	protected void onPostCreate(Bundle savedInstanceState) {
		super.onPostCreate(savedInstanceState);
		_drawerToggle.syncState();
	}

	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent intent) {
		Avatar avatar = dataProvider.getUser().getAvatar();
		switch (requestCode) {
		case Crop.REQUEST_TAKE_PHOTO:
			if (resultCode == RESULT_OK) {
				Crop.beginCrop(Uri.fromFile(Avatar.tmpPhotoFile), avatar.getBitmapFile(), this, false, avatar.getCropParamsFile(), null);
			} else if (resultCode == RESULT_CANCELED) {
			} else {
				UIHelper.toast(R.string.failed_to_change_avatar);
			}
			break;
		case Crop.REQUEST_PICK:
			if (resultCode == RESULT_OK) {
				Crop.beginCrop(intent.getData(), avatar.getBitmapFile(), this, false, avatar.getCropParamsFile(), null);
			} else if (resultCode == RESULT_CANCELED) {
			} else {
				UIHelper.toast(R.string.failed_to_change_avatar);
			}
			break;
		case Crop.REQUEST_CROP:
			if (resultCode == RESULT_OK) {
				AvatarSender sender = new AvatarSender(SessionManager.getSession());
				CropParams cropParams = (CropParams) intent.getSerializableExtra(Crop.KEY_CROP_PARAMS);
				avatar.setCropParams(cropParams);
				sender.updateAvatarAsync(dataProvider.getUser().getUserId(), avatar.getBitmapFile(), cropParams);
				AvatarMemoryCache.getInstance().onUserAvatarChanged(avatar);
				NotificationManager.notifyObservers(Event.AVATAR_CHANGED, true);
				if (Avatar.tmpPhotoFile.exists()) {
					Avatar.tmpPhotoFile.delete();
				}
			} else if (resultCode == Crop.RESULT_ERROR) {
				Toast.makeText(this, Crop.getError(intent).getMessage(), Toast.LENGTH_SHORT).show();
			} else if (resultCode == RESULT_CANCELED) {
			} else {
				UIHelper.toast(R.string.failed_to_change_avatar);
			}
			break;
            case GRADE_REQUEST_TAKE_A_PICTURE:
                if (resultCode == RESULT_OK) {
                    List<Fragment> fragments = getSupportFragmentManager().getFragments();
                    for (Fragment fragment : fragments) {
                        if (fragment instanceof JournalGradeAttendanceDialog) {
                            JournalGradeAttendanceDialog journalGradeAttendanceDialog = (JournalGradeAttendanceDialog) fragment;
                            journalGradeAttendanceDialog.photoIsTaken();
                            break;
                        }
                    }
                } else if (resultCode == Crop.RESULT_ERROR) {
                    Toast.makeText(this, "Ошибка", Toast.LENGTH_SHORT).show();
                }
                break;
            case GRADE_REQUEST_CHOOSE_FROM_GALLERY:
                if (resultCode == RESULT_OK) {
                    List<Fragment> fragments = getSupportFragmentManager().getFragments();
                    for (Fragment fragment : fragments) {
                        if (fragment instanceof JournalGradeAttendanceDialog) {
                            JournalGradeAttendanceDialog journalGradeAttendanceDialog = (JournalGradeAttendanceDialog) fragment;
                            journalGradeAttendanceDialog.addScreenshot(intent.getData());
                            break;
                        }
                    }
                } else if (resultCode == Crop.RESULT_ERROR) {
                    Toast.makeText(this, "Ошибка", Toast.LENGTH_SHORT).show();
                }
                break;
		default:
			assert false;
			break;
		}
		super.onActivityResult(requestCode, resultCode, intent);
	}

	
	@Override
	public void onConfigurationChanged(Configuration newConfig) {
		super.onConfigurationChanged(newConfig);
		_drawerToggle.onConfigurationChanged(newConfig);
	}

	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		return _drawerToggle.onOptionsItemSelected(item) || super.onOptionsItemSelected(item);
	}

	private Fragment getFragmentByIndex(int index) {
        switch (_items.get(index).captionId) {
            case R.string.personal_room_caption:
                return new PersonalAccountFragment();
            case R.string.bookshelf_caption:
                return new BookshelfFragment();
            case R.string.schedule_caption:
                if (provider.getUser().isPupilOrParent()) {
                    return new ScheduleFragment();
                } else {
                    return new EventsFragment();
                }
            case R.string.diary_caption:
                return new DiaryFragment();
            case R.string.journal_caption:
            	return new BigJournalFragment();
            case R.string.statistic_caption:
                return new StatisticsFragment();
            case R.string.settings_caption:
                return new SettingsFragment();
            default:
                throw new UnsupportedOperationException();
        }
    }

	private Fragment getFragmentByCaptionId(int captionId) {
        switch (captionId) {
            case R.string.personal_room_caption:
                return new PersonalAccountFragment();
            case R.string.bookshelf_caption:
                return new BookshelfFragment();
            case R.string.schedule_caption:
                if (provider.getUser().isPupilOrParent()) {
                    return new ScheduleFragment();
                } else {
                    return new EventsFragment();
                }
            case R.string.diary_caption:
                return new DiaryFragment();
            case R.string.journal_caption:
            	return new BigJournalFragment();
            case R.string.statistic_caption:
                return new StatisticsFragment();
            case R.string.settings_caption:
                return new SettingsFragment();
            default:
                throw new UnsupportedOperationException();
        }
    }
	
	
	public void updateActionbarTitle(int stringRes, int colorRes) {
		inflater.setCustomViewTitle(stringRes, App.getInstance().getResources().getColor(colorRes));
		// handle moving to the bottom in fragments
		// inflater.moveToTheBottomIfNeeded();
	}
	
	public void updateActionbarTitle(final String title, int colorRes) {
        inflater.setCustomViewTitle(title, App.getInstance().getResources().getColor(colorRes));
    }

	public void selectItemByCaptionId(int captionId) {
		Fragment fragment = getFragmentByCaptionId(captionId);
		int position = -1;
		for (int i=0;i<_items.size();i++) {
			if (captionId== _items.get(i).captionId) {
				position =i;
				break;
			}	
		}
		selectFragmentItem(position, fragment);
	}
	
	private void selectItem(int position) {
		Fragment fragment = getFragmentByIndex(position);
		selectFragmentItem(position,fragment);
	}
	
	private void selectFragmentItem(int position,Fragment fragment) {
		inflater.resetBothActionBars();
		inflater.addCustomViewLeftButton(this, _items.get(position).barIconId, R.id.iv_book);
		if (fragment instanceof ActionBarInflater) {
			((ActionBarInflater) fragment).inflateActionBar(getSupportActionBar().getCustomView());
		}

		FragmentManager fragmentManager = getSupportFragmentManager();
		fragmentManager.beginTransaction().replace(R.id.content_frame, fragment).commit();

		_navigationItems.setItemChecked(position, true);
		// navigationDrawerAdapter.notifyDataSetChanged();
		_drawerLayout.postDelayed(new Runnable() {
			@Override
			public void run() {
				_drawerLayout.closeDrawer(_leftDrawer);
			}
		}, 200);
		_currentPage = position;

		Editor edit = PreferenceManager.getDefaultSharedPreferences(this).edit();
		edit.putInt(KEY_SELECTED_ITEM, position);
		edit.commit();
	}

	static class NavigationItemModel {
		final int iconId;
		final int selectedIconId;
		final int barIconId;
		final int captionId;
		final int colorId;
		final int itemId;

		NavigationItemModel(int iconId, int selectedIconId, int barIconId, int captionId, int colorId, int itemId) {
			this.iconId = iconId;
			this.selectedIconId = selectedIconId;
			this.barIconId = barIconId;
			this.captionId = captionId;
			this.colorId = colorId;
			this.itemId = itemId;
		}
	}

	class NavigationDrawerAdapter extends ArrayAdapter<NavigationItemModel> {
		NavigationDrawerAdapter(Context context, List<NavigationItemModel> items) {
			super(context, R.layout.navigation_item, items);
		}

		@Override
		public boolean isEnabled(int position) {
			return position != _currentPage;
		}

		@Override
		public boolean areAllItemsEnabled() {
			return false;
		}

		@Override
		public View getView(int position, View convertView, ViewGroup parent) {
			LayoutInflater inflater = (LayoutInflater) getContext().getSystemService(Context.LAYOUT_INFLATER_SERVICE);

			NavigationItemModel model = getItem(position);

			View itemView = inflater.inflate(R.layout.navigation_item, parent, false);
			assert itemView != null;
			// itemView.setEnabled(position != _currentPage);
			ImageView icon = (ImageView) itemView.findViewById(R.id.item_icon);
			icon.setImageResource(_currentPage == position ? model.selectedIconId : model.iconId);
			itemView.setId(model.itemId);
			TextView caption = (TextView) itemView.findViewById(R.id.item_caption);
			caption.setText(getResources().getString(model.captionId).toUpperCase().replace(' ', '\n'));
			// caption.setTextColor(getResources().getColor(model.colorId));
			caption.setTextColor(getResources().getColorStateList(model.colorId));

			return itemView;
		}
	}

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.iv_book:
			if (!_drawerLayout.isDrawerOpen(Gravity.LEFT))
				_drawerLayout.openDrawer(Gravity.LEFT);
			else
				_drawerLayout.closeDrawer(Gravity.LEFT);
			break;

		default:
			break;
		}
	}

	@Override
	public void onClick(DialogInterface dialog, int which) {
		// if fragment implements OnClickListener, let it handle the event
		// in turn, this method is invoked from dialogFragments.
		Fragment fragment = getSupportFragmentManager().findFragmentById(R.id.content_frame);
		if (fragment instanceof android.content.DialogInterface.OnClickListener) {
			((android.content.DialogInterface.OnClickListener) fragment).onClick(dialog, which);
		} else {
		}
	}

	@Override
	public void onSearchFilterItemSelected(String item, FilterType type) {
		Fragment fragment = getSupportFragmentManager().findFragmentById(R.id.content_frame);
		if (fragment instanceof OnSearchFilterItemSelectedListener) {
			((OnSearchFilterItemSelectedListener) fragment).onSearchFilterItemSelected(item, type);
		}
	}

	@Override
	public void onRemoveFilter(FilterType type) {
		Fragment fragment = getSupportFragmentManager().findFragmentById(R.id.content_frame);
		if (fragment instanceof OnSearchFilterItemSelectedListener) {
			((OnSearchFilterItemSelectedListener) fragment).onRemoveFilter(type);
		}
	}

	@Override
	public void onCancelled(FilterType type) {
		Fragment fragment = getSupportFragmentManager().findFragmentById(R.id.content_frame);
		if (fragment instanceof OnSearchFilterItemSelectedListener) {
			((OnSearchFilterItemSelectedListener) fragment).onCancelled(type);
		}
	}

	@Override
	public void onLogout() {
		// clear saved page
		Editor edit = PreferenceManager.getDefaultSharedPreferences(this).edit();
		edit.putInt(KEY_SELECTED_ITEM, 0);
		edit.commit();
		startActivity(new Intent(getApplicationContext(), LoginActivity.class));
		finish();
	}

	private int actionbarHeight;
	private NavigationDrawerAdapter navigationDrawerAdapter;

	@Override
	public boolean dispatchTouchEvent(MotionEvent ev) {
		boolean consumed = false;
		if (ev.getX() > _leftDrawer.getRight() && ev.getY() > actionbarHeight && _drawerLayout.isDrawerOpen(Gravity.LEFT)) {
			consumed = gestureDetector.onTouchEvent(ev);
		}
		return consumed || super.dispatchTouchEvent(ev);
	}

	private void checkNetwork() {
		if (!LoginActivity.isOffline(this))
			return;

		ConnectivityManager connMgr = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
		NetworkInfo networkInfo = connMgr.getActiveNetworkInfo();
		if (networkInfo == null || !networkInfo.isConnected())
			return;

		DialogInterface.OnClickListener listener = new DialogInterface.OnClickListener() {
			@Override
			public void onClick(DialogInterface dialog, int which) {
				switch (which) {
				case DialogInterface.BUTTON_POSITIVE:
					startActivity(new Intent(getApplicationContext(), LoginActivity.class));
					finish();
					break;
				case DialogInterface.BUTTON_NEGATIVE:
					if (_offlineTimer != null)
						_offlineTimer.cancel();
					_offlineTimer = new Timer();
					Calendar now = new GregorianCalendar();
					now.add(Calendar.MINUTE, 10);
					_offlineTimer.schedule(new TimerTask() {
						@Override
						public void run() {
							checkNetwork();
						}
					}, now.getTime(), NETWORK_CHECK_STEP);
					break;
				}
			}
		};
		try {
			final AlertDialog.Builder builder = new AlertDialog.Builder(this).setMessage(R.string.connection_resumed)
					.setPositiveButton(R.string.yes, listener).setNegativeButton(R.string.no, listener);
			runOnUiThread(new Runnable() {
				@Override
				public void run() {
					try {
						builder.show();
					} catch (Exception e) {
						if (_offlineTimer != null)
							_offlineTimer.cancel();
						_offlineTimer = null;
					}
				}
			});
		} catch (Exception e) {
			if (_offlineTimer != null)
				_offlineTimer.cancel();
			_offlineTimer = null;
		}
	}

	@Override
	protected void onUIMustBeUpdatedOnDataChanged(Event event, Object[] extra) {
		switch (event) {
		case TEXTBOOKS_CHANGED:
			int textbookIdToOpen = dataProvider.getTextbookIdToShowOnLogin();
			if (textbookIdToOpen != 0) {
				dataProvider.setTextbookIdToShowOnLogin(0);
				Intent intent = new Intent(getApplicationContext(), TextbookComponentEditActivity.class);
				intent.addFlags(Intent.FLAG_ACTIVITY_SINGLE_TOP).addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP).addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
				intent.putExtra(TextbookComponentEditActivity.TEXTBOOK_ID, textbookIdToOpen);
				startActivity(intent);
			}
			break;

		case FAILED_TO_LOAD_AVATAR:
			UIHelper.toast(R.string.failed_to_load_avatar);
			break;

		default:
			assert false;
			break;
		}
	}

	@Override
	protected List<Event> getSubscriptionEvents() {
		return Arrays.asList(Event.TEXTBOOKS_CHANGED, Event.FAILED_TO_LOAD_AVATAR);
	}

    @Override
    public void updateJournal() {
        Fragment fragmentById = getSupportFragmentManager().findFragmentById(R.id.content_frame);
        if (fragmentById != null && fragmentById instanceof JournalUpdate) {
            JournalUpdate journalUpdate = (JournalUpdate) fragmentById;
            journalUpdate.updateJournal();
        }
    }
}