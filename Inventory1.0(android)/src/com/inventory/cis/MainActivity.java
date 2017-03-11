package com.inventory.cis;

import android.app.Activity;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;


public class MainActivity extends Activity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);

		try {

			setContentView(R.layout.mainscreen);
			new SelectDataTask().execute();
		} catch (Exception e) {
			//e.printStackTrace();
		} catch (OutOfMemoryError o) {
			//o.printStackTrace();
		}
	}
	
	

	private class SelectDataTask extends AsyncTask<String, Void, String> {

		protected void onPreExecute() {

		}

		// automatically done on worker thread (separate from UI thread)
		protected String doInBackground(final String... args) {
			return null;
		}

		// can use UI thread here
		protected void onPostExecute(final String result) {

			Thread splashThread = new Thread() {
				public void run() {

					synchronized (this) {
						try {
							wait(2000);
						} catch (InterruptedException e) {
							//e.printStackTrace();
						}
					}

					mainpage();
				
				}
				
			};

			splashThread.start();

		}
	}
	
	

	protected void mainpage() {
		try {

			Intent i = new Intent(this, LoginActivity.class);
			startActivity(i);
			finish();
			
		} catch (Exception e) {
			//e.printStackTrace();
		} catch (OutOfMemoryError o) {
			//o.printStackTrace();
		}
	}


}
