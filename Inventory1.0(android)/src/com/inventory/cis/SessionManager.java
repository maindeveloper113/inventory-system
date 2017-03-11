package com.inventory.cis;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.os.AsyncTask;

import java.util.HashMap;

public class SessionManager {
	// Shared Preferences
	SharedPreferences pref;
	public static String logout_id = "0";
	// Editor for Shared preferences
	Editor editor;

	// Context
	Context _context;

	// Shared pref mode
	public static final int PRIVATE_MODE = 0;

	// Sharedpref file name
	public static final String PREF_NAME = "AndroidHivePref";

	// All Shared Preferences Keys
	private static final String IS_LOGIN = "IsLoggedIn";

	// Email address (make variable public to access from outside)
	public static final String KEY_EMAIL = "email";


	public static final String KEY_UserId = "user_id";
	public static final String KEY_UserPassword = "user_pass";

	SessionManager session;
	HashMap<String, String> user;

	AsyncTask<Void, Void, Void> mRegisterTask;
	Controller aController;

	// String account_type;
	// Constructor
	public SessionManager(Context context) {
		this._context = context;
		pref = _context.getSharedPreferences(PREF_NAME, PRIVATE_MODE);
		editor = pref.edit();
	}

	/**
	 * Create login session
	 * */
	public void createLoginSession(
			String user_id) {
		// Storing login value as TRUE
		//editor.putBoolean(IS_LOGIN, true);
		editor.putString(KEY_UserId, user_id);
		// commit changes
		editor.commit();
	}

	public void registerUser(String email, String pass) {
		editor.putString(KEY_EMAIL, email);
		editor.putString(KEY_UserPassword, pass);
		// commit changes
		editor.commit();
	}
	/**
	 * Check login method wil check user login status If false it will redirect
	 * user to login page Else won't do anything
	 * */
	public void checkLogin() {
		// Check login status


		if (!this.isLoggedIn()) {
			// user is not logged in redirect him to Login Activity
			Intent i = new Intent(_context, LoginActivity.class);
			// Closing all the Activities
			i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);

			// Add new Flag to start new Activity
			i.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);

			// Staring Login Activity
			_context.startActivity(i);

		}

	}

	/**
	 * Get stored session data
	 * */
	public HashMap<String, String> getUserDetails() {
		HashMap<String, String> user = new HashMap<String, String>();

		// user email id
		user.put(KEY_EMAIL, pref.getString(KEY_EMAIL, null));
		user.put(KEY_UserId, pref.getString(KEY_UserId, null));
		user.put(KEY_UserPassword, pref.getString(KEY_UserPassword, null));

		// return user
		return user;
	}

	/**
	 * Clear session details
	 * */
	public void logoutUser() {
		// Clearing all data from Shared Preferences
		try {

			registerUser("","");

			Intent i = new Intent(_context, LoginActivity.class);
			// Closing all the Activities
			i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);

			// Add new Flag to start new Activity
			i.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
			logout_id = "1";
			// Staring Login Activity
			_context.startActivity(i);

		} catch (Exception e) {
			//e.printStackTrace();
		}
	}

	/**
	 * Quick check for login
	 * **/
	// Get Login State
	public boolean isLoggedIn() {
		return pref.getBoolean(IS_LOGIN, false);
	}
}
