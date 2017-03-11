package com.inventory.cis;

import android.content.Context;
import android.content.SharedPreferences;
import android.content.res.Configuration;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;


public class StaticData {


	public static final String ip_key = "ip";
	public static final String port_key = "port";

    public static final String sublink = "/inventory/Services/";

	public static String getlink(Context context) {
		SharedPreferences prefs = context.getSharedPreferences(SessionManager.PREF_NAME, SessionManager.PRIVATE_MODE);

		String ip = prefs.getString(ip_key, "rescuestartup.com");//"No name defined" is the default value.
		String port = prefs.getString(port_key, "80");
		String link;
		if (port.equals("")) {
			if (port.equals("80"))
				link = "http://www." + ip + sublink;
			else
				link = "http://www." + ip + sublink;
		}
		else {
			if (port.equals("80"))
				link = "http://www." + ip + sublink;
			else
				link = "http://www." + ip + ":" + port + sublink;

		}

		//link = "http://www.rescuestartup.com/inventory/Services/";
		//link = "http://198.18.52.11/inventory/Services/";
		return link;
	}

	public static boolean isTablet(Context context) {
		return (context.getResources().getConfiguration().screenLayout
				& Configuration.SCREENLAYOUT_SIZE_MASK)
				>= Configuration.SCREENLAYOUT_SIZE_LARGE;
	}


	public static boolean isNetworkConnected(Context context) {
		
		ConnectivityManager connectivityManager = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
		NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
		return activeNetworkInfo != null && activeNetworkInfo.isConnected();
	}


}
